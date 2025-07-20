<script setup lang="ts">
    import { Head, router, usePage } from '@inertiajs/vue3'
    import { ComputedRef, computed, ref } from 'vue'
    import { type BreadcrumbItem } from '@/types'
    import AppLayout from '@/layouts/AppLayout.vue'
    import ResepFormModal from './Partials/ResepFormModal.vue'
    import DetailResepModal from './Partials/DetailResepModal.vue'

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
        },
        {
            title: 'Resep',
            href: '/resep',
        },
    ]

    interface Resep {
        resep_id: number
        nama_resep: string
        is_racikan: boolean
    }

    interface Signa {
        signa_id: number
        signa_nama: string
    }

    interface Obat {
        obatalkes_id: number
        obatalkes_kode: string
        obatalkes_nama: string
        stok: number
    }

    const props = defineProps<{
        reseps?: Resep[]
        signas?: Signa[]
        obats?: Obat[]
        resepDetail?: any
    }>()

    const reseps            = props.reseps ?? []
    const signas            = props.signas ?? []
    const obats             = props.obats ?? []
    const showModal         = ref(false)
    const showDetailModal   = ref(false)
    const resepDetail       = ref()

    function openModal() {
        showModal.value = true
    }

    function closeModal() {
        showModal.value = false
    }

    function closeDetailModal() {
        showDetailModal.value = false
    }

    function lihatResep(id: number) {
        router.get(`/resep/${id}`, {}, {
            preserveState: true,
            preserveScroll: true,
            only: ['resepDetail'],
            onSuccess: () => {
                const page = usePage()
                resepDetail.value = page.props.resepDetail
                showDetailModal.value = true
            }
        })
    }
</script>

<template>
    <Head title="Resep" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="mb-4">
                <button @click="openModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded cursor-pointer">
                    + Tambah Resep
                </button>
            </div>

            <div class="bg-white shadow rounded p-4">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nama Resep</th>
                            <th class="px-4 py-2">Jenis</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="resep in reseps" :key="resep.resep_id" class="border-b">
                            <td class="px-4 py-2">{{ resep.resep_id }}</td>
                            <td class="px-4 py-2">{{ resep.nama_resep }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800" v-if="resep.is_racikan">Racikan</span>
                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800" v-else>Bebas</span>
                            </td>
                            <td class="px-4 py-2">
                                <button @click="lihatResep(resep.resep_id)" class="text-indigo-600 hover:underline cursor-pointer">Lihat</button>
                            </td>
                        </tr>
                        <tr v-if="reseps.length === 0">
                            <td colspan="4" class="text-center text-gray-500 py-4">Belum ada data resep</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <ResepFormModal
            v-if="showModal"
            :signas="signas"
            :obats="obats"
            @close="closeModal"
        />
        <DetailResepModal
            v-if="showDetailModal && resepDetail"
            :resep="resepDetail"
            @close="closeDetailModal"
        />
    </AppLayout>
</template>
