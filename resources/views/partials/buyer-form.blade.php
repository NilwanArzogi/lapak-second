<div x-show="cart.length > 0">
    <p class="section-label">Informasi Pembeli</p>

    <input type="text"
           x-model="customer.name"
           placeholder="Nama Lengkap"
           class="form-input">

    <input type="email"
           x-model="customer.email"
           placeholder="Alamat Email"
           class="form-input">

    <input type="tel"
           x-model="customer.phone"
           placeholder="Nomor HP / WhatsApp"
           class="form-input">
</div>
