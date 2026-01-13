<div x-data="{
    consultants: @js($consultants),
    consultantsIds: @entangle('data.selected_consultants').live,
    manager_id: @entangle('data.manager_id').live,

    init() {
        if (!this.consultantsIds) {
            this.consultantsIds = [];
        }
        this.$watch('consultantsIds', async (newIds) => {
            if (newIds?.length) {
                const consultants = await $wire.searchConsultants(newIds);
                consultants.forEach(c => this.consultants.push(c));
            }
        });
    },
    
    deleteConsultant(id) {
        this.consultants = this.consultants.filter(c => c.id !== id);
        this.consultantsIds = this.consultantsIds.filter(cId => cId !== id);
        $wire.removeConsultant(id);
    },
    }"
    x-on:delete-consultant.window="deleteConsultant($event.detail.id)"
    >
    <div class="flex grid sm:grid-cols-6 md:grid-cols-9 lg:grid-flow-cols-12 gap-3">
        <template x-if="consultants.length > 0">
            <template x-for="consultant in consultants" :key="consultant.id">
            <div class="flex justify-evenly min-w-55 p-2 sm:col-span-3 md:col-span-3 lg:col-span-4 xl:col-span-3 rounded-md shadow-md ">
                <div class="min-w-15">
                    <template x-if="consultant.image">
                    <img class="rounded-full h-15" :src="consultant.image">
                    </template>
                </div>
                <div class="flex flex-col justify-center">
                    <span x-text="consultant.name" class="text-base">
                    </span>
                    <span x-text="consultant.role" class="font-xs text-gray-600">
                    </span>
                </div>
                <div x-data>
                    <div class="flex min-w-10 h-10 items-center justify-center rounded-full hover:bg-red-100 transition duration-500">
                        <div @click="$dispatch('delete-consultant', {id: consultant.id})">
                            <template x-if="consultant.id != manager_id">
                            <x-filament::icon
                                icon="heroicon-o-trash"
                                color="red"
                            />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            </template>
        </template>
        <template x-if="consultants.length == 0">
            <div class="flex col-span-full">
            <x-filament::empty-state class="flex grow">
                <x-slot name="heading">
                    Nenhum consultor no projeto
                </x-slot>

                <x-slot name="description">
                    Clique no botão <span class="underline text-primary-600">Adicionar Consultor</span> para adicionar os consultores que irão trabalhar nesse projeto.
                </x-slot>
            </x-filament::empty-state>
            </div>
        </template>
    </div>
</div>