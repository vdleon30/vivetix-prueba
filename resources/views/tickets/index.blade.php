<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if ($selectedEvent)
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <a class="btn btn-success" href="{{ route('tickets.sale', $selectedEvent) }}" role="button">Vender
                            Tickets</a>
                    </div>
                </div>
            @endif
            <div class="row justify-content-end">
                <div class="col-lg-4 col-6">
                    <x-input-label for="event" :value="__('Evento')" />
                    <select onchange="changeFilter(this)" name="event"
                        class="custom-select border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                        @empty($selectedEvent)
                            <option value="" selected disabled>Seleccionar</option>
                        @endempty
                        @foreach ($events as $event)
                            <option {{ $selectedEvent == $event->id ? 'selected' : '' }} value="{{ $event->id }}">
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @include('layouts.include.messages')
            @empty($selectedEvent)
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Seleccione al menos un evento</h4>
                </div>
            @endempty
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                <table class="table border-0 rounded">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-0 rounded">
                        <tr>
                            <th class="px-6 py-4">Cliente</th>
                            <th class="px-6 py-4">Cantidad de tickets</th>
                            <th class="px-6 py-4">Evento</th>
                            <th class="px-6 py-4">Fecha de venta</th>
                            <th class="px-6 py-4">Comprobante</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $ticket->client_name }}
                                    <span>{{ $ticket->client_email }}</span>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $ticket->quantity }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $ticket->event->title }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a target="_blank" href="{{ asset($ticket->proof) }}">Ver</a>
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
                {{ $tickets->appends(['event' => $selectedEvent]) }}
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    function changeFilter(element) {
        window.location = `{{ route('tickets.index') }}?event=${element.value}`;
    }
</script>
