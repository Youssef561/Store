@extends('layout/dashboard');

@section('title',$category->name.' Category')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
    <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
@endsection

@section('content')

    {{-- show errors --}}
    <x-alert/>

    <h2 class="justify-content-center"> Products of this Category</h2>

    <table class="table table-hover align-middle text-center">
        <thead class="table-dark">
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created at</th>
        </tr>
        </thead>
        <tbody>

        @php
            $number = 1;
                                    // we used products() to get relation instead of using product only if we want to get collection, so products() let me modify it
            $products = $category->products()->with('store')->latest()->paginate(10);
        @endphp

        @forelse($products as $product)
            <tr>
                <td>{{$number++}}</td>
                <td>{{ $product->name }}</td>

                <td>
                    <span class="badge bg-info">{{ $product->store->name }}</span>
                </td>

                <td>
                    <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </td>

                <td>{{ $product->created_at->format('Y-m-d') }}</td>

            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-muted">No categories found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $products->appends(request()->query())->links() }}


    </main>

@endsection
