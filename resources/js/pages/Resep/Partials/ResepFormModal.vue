<script setup lang="ts">
    import { ComputedRef, computed, ref, reactive } from 'vue';
    import { router, usePage } from '@inertiajs/vue3'

    const props = defineProps<{
        signas: Array<{ signa_id: number; signa_nama: string }>,
        obats: Array<{ obatalkes_id: number; obatalkes_nama: string; obatalkes_kode: string; stok: number }>
    }>()

    const emit = defineEmits(['close', 'submit'])

    const form = reactive({
        nama_resep: '',
        non_racikan: [
            { obatalkes_id: 0, qty: 1, signa_id: null }
        ],
        racikans: [
            {
                nama: '',
                signa_id: null,
                items: [{ obatalkes_id: 0, qty: 1 }]
            }
        ]
    })
    interface FlashMessages {
    success?: string;
    error?: string;
    }

    function addNonRacikan() {
        form.non_racikan.push({ obatalkes_id: 0, qty: 1, signa_id: null })
    }

    function removeNonRacikan(index: number) {
        form.non_racikan.splice(index, 1)
    }

    function addRacikan() {
        form.racikans.push({
            nama: '',
            signa_id: null,
            items: [{ obatalkes_id: 0, qty: 1 }]
        })
    }

    function removeRacikan(index: number) {
        form.racikans.splice(index, 1)
    }

    function addItemToRacikan(index: number) {
        form.racikans[index].items.push({ obatalkes_id: 0, qty: 1 })
    }

    function removeItemFromRacikan(rIndex: number, iIndex: number) {
        form.racikans[rIndex].items.splice(iIndex, 1)
    }

    function submit() {
        if (!isQtyValid()) return

        router.post('/resep', form, {
            onSuccess: () => {
                router.visit('/resep')
            },
            onError: (errors) => {
                for (const field in errors) {
                    alert(errors[field])
                    break
                }
            }
        })
    }

    function getStokById(id: number): number {
        const obat = props.obats.find((o) => o.obatalkes_id === id);
        return obat ? obat.stok : 0;
    }

    function isQtyValid(): boolean {
        for (const item of form.non_racikan) {
            const stok = getStokById(item.obatalkes_id)
            if (item.qty > stok) {
                alert(`Qty obat non racikan melebihi stok. Stok tersedia: ${stok}`)
                return false
            }
        }

        for (const racikan of form.racikans) {
            for (const item of racikan.items) {
                const stok = getStokById(item.obatalkes_id)
                if (item.qty > stok) {
                    alert(`Qty obat racikan "${racikan.nama}" Melebihi stok. Stok tersedia: ${stok}`)
                    return false
                }
            }
        }

        return true
    }
</script>

<template>
    <div class="fixed inset-0 z-50 bg-gray-500/70 flex items-center justify-center">
        <div class="bg-white w-full max-w-3xl p-6 rounded-lg shadow-lg overflow-y-auto max-h-[90vh]">
            <h2 class="text-2xl font-semibold mb-4">Tambah Resep</h2>
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Resep</label>
                <input v-model="form.nama_resep" type="text" class="w-full border px-3 py-2 rounded" />
            </div>
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Obat Non Racikan</h3>
                <div v-for="(item, index) in form.non_racikan" :key="index" class="flex gap-2 items-center mb-2">
                    <select v-model="item.obatalkes_id" class="w-full border px-2 py-1 rounded">
                        <option disabled value="0">Pilih Obat</option>
                        <option v-for="obat in props.obats" :key="obat.obatalkes_id" :value="obat.obatalkes_id" :disabled="obat.stok <= 0">
                            {{ obat.obatalkes_nama }} (stok: {{ obat.stok }})
                        </option>
                    </select>
                    <input v-model.number="item.qty" type="number" min="1" class="w-20 border px-2 py-1 rounded" />
                    <select v-model="item.signa_id" class="w-full border px-2 py-1 rounded">
                        <option disabled value="">Pilih Signa</option>
                        <option v-for="signa in props.signas" :value="signa.signa_id">{{ signa.signa_nama }}</option>
                    </select>
                    <button @click="removeNonRacikan(index)" class="text-red-500 text-sm">Hapus</button>
                </div>
                <button @click="addNonRacikan" class="text-blue-600 text-sm hover:underline mt-2">+ Tambah Obat Non Racikan</button>
            </div>
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Racikan</h3>
                <div v-for="(racikan, rIndex) in form.racikans" :key="rIndex" class="mb-4 border p-4 rounded">
                    <div class="mb-2 flex gap-2 items-center">
                        <input v-model="racikan.nama" placeholder="Nama Racikan" class="w-full border px-2 py-1 rounded" />
                        <select v-model="racikan.signa_id" class="w-52 border px-2 py-1 rounded">
                            <option disabled value="0">Pilih Signa</option>
                            <option v-for="signa in props.signas" :value="signa.signa_id">{{ signa.signa_nama }}</option>
                        </select>
                        <button @click="removeRacikan(rIndex)" class="text-red-500 text-sm">Hapus Racikan</button>
                    </div>
                    <div v-for="(item, iIndex) in racikan.items" :key="iIndex" class="flex gap-2 items-center mb-2">
                        <select v-model="item.obatalkes_id" class="w-full border px-2 py-1 rounded">
                            <option disabled value="0">Pilih Obat</option>
                            <option v-for="obat in props.obats" :key="obat.obatalkes_id" :value="obat.obatalkes_id" :disabled="obat.stok <= 0">
                                {{ obat.obatalkes_nama }} (stok: {{ obat.stok }})
                            </option>
                        </select>
                        <input v-model.number="item.qty" type="number" min="1" class="w-20 border px-2 py-1 rounded" />
                        <button @click="removeItemFromRacikan(rIndex, iIndex)" class="text-red-500 text-sm">Hapus</button>
                    </div>
                    <button @click="addItemToRacikan(rIndex)" class="text-blue-600 text-sm hover:underline mt-2">+ Tambah Obat ke Racikan</button>
                </div>
                <button @click="addRacikan" class="text-blue-600 text-sm hover:underline">+ Tambah Racikan Baru</button>
            </div>
            <div class="flex justify-end gap-2 pt-4 border-t">
                <button @click="$emit('close')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 cursor-pointer">Batal</button>
                <button @click="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer">Simpan</button>
            </div>
        </div>
    </div>
</template>
