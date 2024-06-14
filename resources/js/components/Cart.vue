<template>
    <div>
        <table class="table table-bordered table-hover cart-table">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Herramientas</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in cartItems" :key="product.id">
                    <td>
                        <img :src="'/images/' + (product.product.image || 'productos_por_defecto.jpg')" alt="Producto"
                            class="product-image">
                    </td>
                    <td>
                        {{ product.product.name || 'No existen productos en el carrito' }}
                    </td>
                    <td>
                        <input type="number" v-model.number="product.quantity" min="1"
                            class="form-control form-control-sm d-inline quantity-input">
                        <button type="button" class="btn btn-primary btn-sm mt-0 mb-1 ml-2"
                            @click="updateProduct(product.id)">Actualizar</button>
                    </td>
                    <td>
                        ${{ product.product.price || 0 }}
                    </td>
                    <td>
                        ${{ parseFloat((product.product.price || 0) * product.quantity).toFixed(2) }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm"
                            @click="removeProduct(product.id)">Eliminar</button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>Cantidad de productos:</strong></td>
                    <td><strong>{{ totalQuantity }}</strong></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>Total a pagar:</strong></td>
                    <td><strong>${{ totalPrice }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const props = defineProps({
    cartItems: Array,
    totalQuantity: Number,
    totalPrice: Number
});

const emit = defineEmits(['update', 'remove']);

const cartItems = ref(props.cartItems);
const totalQuantity = ref(props.totalQuantity);
const totalPrice = ref(props.totalPrice);

watch(props, (newProps) => {
    cartItems.value = newProps.cartItems;
    totalQuantity.value = newProps.totalQuantity;
    totalPrice.value = newProps.totalPrice;
});

function updateProduct(id) {
    const product = cartItems.value.find(item => item.id === id);
    axios.put(`/cart/update/${id}`, { quantity: product.quantity })
        .then(response => {
            Swal.fire({
                icon: 'success',
                title: 'Producto Actualizado',
                text: response.data.success,
                timer: 1000,
                timerProgressBar: true,
                showConfirmButton: false
            });
            setTimeout(() => {
                emit('update');
                window.location.reload();
            }, 1000);
        })
        .catch(error => {
            Swal.fire({
                icon: 'warning',
                title: 'Stock Excedido',
                text: error.response.data.error,
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: true
            });
        });
}

function removeProduct(id) {
    axios.delete(`/cart/remove/${id}`)
        .then(response => {
            Swal.fire({
                icon: 'success',
                title: 'Producto Eliminado',
                text: response.data.success,
                timer: 1000,
                timerProgressBar: true,
                showConfirmButton: false
            });
            setTimeout(() => {
                emit('remove');
                window.location.reload();
            }, 1000);
        })
        .catch(error => {
            console.error(error.response.data.error);
        });
}
</script>

<style scoped>
.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 1em;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.cart-table thead tr {
    background-color: #f8f9fa;
    text-align: left;
}

.cart-table th,
.cart-table td {
    padding: 12px 15px;
}

.cart-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.cart-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.cart-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

.cart-table tbody tr:hover {
    background-color: #f1f1f1;
}

.product-image {
    max-height: 50px;
    width: auto;
    border-radius: 5px;
    transition: transform 0.2s;
}

.product-image:hover {
    transform: scale(1.1);
}

.quantity-input {
    width: 70px;
}
</style>