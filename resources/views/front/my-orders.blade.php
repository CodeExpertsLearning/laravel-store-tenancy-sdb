<x-guest-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <hr>
        <h5 class="my-20 text-4xl text-center font-extrabold">Meus Pedidos</h5>

        <a href="{{route('front.store', [request('subdomain')])}}" class="mt-2 underline text-blue-600 mb-10 block">Home</a>
        <hr>

        <div class="flex justify-between items-center">

            <div class="accordion-container w-full">
                @forelse($userOrders as $order)
                <div class="ac">
                    <h2 class="ac-header border-b border-gray-200">
                        <button type="button" class="ac-trigger" style="display: flex; justify-content: space-between;">
                           <span> Pedido: {{$order->code}}</span>

                            <span>Status: {{$order->payment_status}}</span>
                        </button>
                    </h2>

                    <div class="ac-panel">
                        <p class="ac-text" style="padding: 2%;">
                            <h3 style="margin-left: 2% !important; margin-bottom: 10px; font-weight: bold;">Items pedido:</h3>

                            <ul style="margin-left: 4% !important;">
                               @php $totalOrder = 0; @endphp

                                @foreach($order->items as $item)
                                    <li>{{$item['name']}}</li>

                                    @php $totalOrder += $item['price']; $shippingValue = $order->shipping_value; @endphp
                                @endforeach
                            </ul>

                            <p style="width: 100%; margin-left: 4%; margin-top: 20px;">
                                Total Pedido: <strong>R$ {{number_format($totalOrder, 2, ',', '.')}}</strong> <br>
                                Frete: <strong>R$ {{number_format($shippingValue, 2, ',', '.')}}</strong>
                                <br>
                                Total com frete: <strong>R$ {{number_format($totalOrder + $shippingValue, 2, ',', '.')}}</strong>
                            </p>
                        </p>
                    </div>
                </div>
                @empty
                    <div class="w-full">
                        <h3>Nenhum pedido encontrado...</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-guest-layout>