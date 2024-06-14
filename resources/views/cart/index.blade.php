<x-app>
    <cart
    :cart-items='@json($cartItems)'
    :total-quantity='{{ $totalQuantity }}'
    :total-price='{{ $totalPrice }}'>
</cart>
</x-app>