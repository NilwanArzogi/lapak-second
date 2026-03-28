@extends('layouts.app')

@section('title', 'Lapak Second — Elektronik Pilihan')

@section('content')

    {{-- Hero --}}
    @include('components.hero')

    {{-- Main Layout --}}
    <main class="main-layout">

        {{-- Sidebar Filter --}}
        @include('components.sidebar-filter')

        {{-- Product Grid --}}
        <div class="products-grid">

            @forelse($products as $product)
                @include('components.product-card', [
                    'product' => $product,
                    'index'   => $loop->index,
                    
                ])
            @empty
                <div class="col-span-full">
                    <i class="fas fa-box-open" style="font-size:2rem;opacity:0.3;display:block;margin-bottom:0.75rem;"></i>
                    Data produk kosong.
                </div>
            @endforelse

        </div>

    </main>

@endsection
