<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a class="btn btn-primary" href="{{ route('events.create') }}" role="button">Crear</a>
                </div>

            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">


                    @include('layouts.include.messages')
                    <table
                        class="table border-0 rounded w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-0 rounded">
                            <tr>
                                <th class="px-6 py-4">Titulo</th>
                                <th class="px-6 py-4">Cantidad de tickets</th>
                                <th class="px-6 py-4">Estado</th>
                                <th class="px-6 py-4">Fecha de evento</th>
                                <th class="px-6 py-4">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($events as $event)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $event->title }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $event->quantity }}</td>

                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $event->status }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="containerButtons">

                                            <a class="btn btn-sm btn-success"
                                                href="{{ route('tickets.sale', $event) }}">Vender</a>
                                            <a class="btn btn-sm btn-info"
                                                href="{{ route('events.edit', $event) }}">Editar</a>
                                            <form action="{{ route('events.destroy', $event) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Borrar</button>
                                            </form>
                                        </div>

                                    </td>
                                @empty
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td colspan="6"
                                        class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        No existen datos
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

            </div>
        </div>
    </div>
</x-app-layout>
