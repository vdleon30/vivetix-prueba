<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @include('layouts.include.messages')

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form action="{{ route('events.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-row row">
                        <div class="form-group mb-3 col-12 col-lg-6">
                            <x-input-label for="title" :value="__('Titulo')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="form-group mb-3 col-12 col-lg-6">
                            <x-input-label for="quantity" :value="__('Cantidad de Tickets')" />
                            <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full"
                                required min=1 />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3 col-12 col-lg-6">
                            <x-input-label for="date" :value="__('Fecha de Evento')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full"
                                required min="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3 col-12 col-lg-6">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <x-text-input-text id="description" name="description" type="text"
                                class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>
                    <div class="d-flex justify-content-end my-4">
                        <button class="btn btn-primary mx-2">Crear</button>
                        <a href="{{ route('events.index') }}" role="button" class="btn btn-danger  mx-2">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</x-app-layout>
