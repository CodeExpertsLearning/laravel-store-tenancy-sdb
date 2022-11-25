<x-guest-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h3 class="text-2xl font-extrabold my-8"></h3>
        <hr>
        <h5 class="my-20 text-4xl text-center font-extrabold">Carrinho</h5>
        <hr>

        <div class="w-1/2 block mx-auto mt-10">
            @php $total = 0; @endphp
            @forelse($cart as $item)
                <div class="mb-4 flex justify-between">
                    <h5 class="text-bold text-2xl mb-4">{{$item['name']}}</h5>
                    <div class="flex">
                    <p class="mr-2">R$ {{number_format($item['price'], 2, ',', '.')}}</p>
                    <p><a class="font-bold text-red-700" href="{{route('cart.remove',[request('subdomain'), $item['slug']])}}">Remover</a></p>
                    </div>
                    @php $total += $item['price'] @endphp
                </div>
            @empty
                <div class="w-full border border-yellow-600 bg-yellow-100 px-4 py-2 rounded text-yellow-600 font-bold text-xl">Nenhum item encontrado...</div>
            @endforelse

            @if($shippings && $cart)
                <div class="block border-t  border-gray-200 my-10 py-10">
                    <h3 class="text-xl font-bold mb-10">Escolha o frete</h3>
                    <ul>
                    @foreach($shippings as $shipping)
                            <li class="block">
                                <input type="radio" name="shipping_value" 
                                    @if(session('shipping_value') == $shipping->price) checked @endif
                                value="{{$shipping->price}}">
                                {{$shipping->name}} - R$ {{number_format($shipping->price, 2, ',', '.')}}
                            </li>
                    @endforeach
                    </ul>
                </div>
            @endif

            @if($cart)
                <div class="border-t border-gray-200 flex justify-between pt-10">
                    <h5 class="text-bold text-2xl mb-4">Total {{session()->has('shipping_value') ? ' + frete' : ''}}</h5>
                    @php $total = session()->has('shipping_value') ? $total + session('shipping_value') : $total; @endphp

                    <p>R$ {{number_format($total, 2, ',', '.')}}</p>
                </div>

                <div class="border-t border-gray-200 flex justify-between pt-4 mt-10">
                   <a href="{{route('cart.cancel', request('subdomain'))}}"
                       class="text-xl font-bold px-4 py-2 rounded bg-red-600 text-white shadow hover:bg-red-300 transition ease-in-out delay-150 uppercase">Cancelar</a>

                       <a href="{{route('checkout.checkout', request('subdomain'))}}"
                       class="text-xl font-bold px-4 py-2 rounded bg-green-600 text-white shadow hover:bg-green-300 transition ease-in-out delay-150 uppercase">Concluir</a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            const urlSaveShipping = '{{route("cart.store-shipping", request("subdomain"))}}'
            let inputs = document.querySelectorAll('input[name="shipping_value"]');
            for(let inputEl of inputs) {
                inputEl.addEventListener('change', e => {
                    let shipping_value = document.querySelector('input[name="shipping_value"]:checked').value
                    fetch(urlSaveShipping, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            "_token" : "{{csrf_token()}}",
                            shipping_value
                        })
                    })
                       .then(res => location.reload())
                })
            }
        </script>
    @endpush

</x-guest-layout>