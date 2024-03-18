<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vender Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @include('layouts.include.messages')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                <form action="{{ route('tickets.saveOrder') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-row row">
                        <h4 style="font-size: 25px" class="text-light">Cliente</h4>

                        <div class="form-group mb-3 col-12 col-lg-6">
                            <x-input-label for="client_name" :value="__('Nombre y Apellido')" />
                            <x-text-input id="client_name" name="client_name" type="text" class="mt-1 block w-full"
                                required />
                            <x-input-error :messages="$errors->get('client_name')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3 col-12 col-lg-6">
                            <x-input-label for="client_email" :value="__('Correo')" />
                            <x-text-input id="client_email" name="client_email" type="email" class="mt-1 block w-full"
                                required />
                            <x-input-error :messages="$errors->get('client_email')" class="mt-2" />
                        </div>
                        <hr style="border-color: grey" class="my-3">
                        <div class=" col-12 my-3">
                            <div class=" form-group card dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 ">
                                <div class="card-body">
                                    <h4 style="font-size: 18px"><strong>Detalles del evento</strong></h4>
                                    <p>Titulo: {{ $event->title }}</p>
                                    <p>Fecha: {{ $event->date }}</p>
                                    <p>Tickets restantes: {{ $event->quantity }}</p>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" value="{{ $event->id }}" name="event_id">

                        <div class="form-group mb-3 col-12 col-lg-6">
                            <x-input-label for="quantity" :value="__('Cantidad de Tickets')" />
                            <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full"
                                required min=1 max="{{ $event->quantity }}" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3 col-12 col-lg-6">
                            <x-input-label for="file" :value="__('Comprobante de pago')" />
                            <x-text-input id="file" name="file" type="file" class="mt-1 block w-full"
                                required accept="image/*, .pdf" />
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>
                    </div>
                    <div class="d-flex justify-content-end my-4">

                        <button class="btn btn-primary mx-2">Crear</button>
                        <a href="{{ route('tickets.index', ['event' => $event->id]) }}" role="button"
                            class="btn btn-danger  mx-2">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
