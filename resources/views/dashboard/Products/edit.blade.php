@extends('layout/dashboard');

@section('title','Edit Product')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')

    {{-- show errors --}}
    <x-alert />


    <form method="POST" action="{{ route('dashboard.products.update',$product->id) }}" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-white">
        @csrf
        @method('put')
        <h4 class="mb-4">Update the Product</h4>

        {{-- Product Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        {{-- Parent Category --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Product Price --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Price</label>
            <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>

        {{-- Product Compare Price --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Compare Price</label>
            <input type="text" name="compare_price" id="c_price" class="form-control" value="{{ old('c_price', $product->compare_price) }}" required>
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        {{-- Product Tags --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Tags</label>
            <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags',$tags) }}">
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label class="form-label d-block">Status</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="statusActive" value="active"
                    {{ old('status', $product->status) == 'active' ? 'checked' : '' }}>
                <label class="form-check-label" for="statusActive">Active</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="statusDraft" value="draft"
                    {{ old('status', $product->status) == 'draft' ? 'checked' : '' }}>
                <label class="form-check-label" for="statusDraft">Draft</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="statusArchived" value="archived"
                    {{ old('status', $product->status) == 'archived' ? 'checked' : '' }}>
                <label class="form-check-label" for="statusArchived">Archived</label>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>

    </form>


    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 1-->
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>150</h3>
                            <p>New Orders</p>
                        </div>
                        <svg
                            class="small-box-icon"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                        >
                            <path
                                d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                            ></path>
                        </svg>
                        <a
                            href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                        >
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 1-->
                </div>
                <!--end::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 2-->
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>53<sup class="fs-5">%</sup></h3>
                            <p>Bounce Rate</p>
                        </div>
                        <svg
                            class="small-box-icon"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                        >
                            <path
                                d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"
                            ></path>
                        </svg>
                        <a
                            href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                        >
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 2-->
                </div>
                <!--end::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 3-->
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>User Registrations</p>
                        </div>
                        <svg
                            class="small-box-icon"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                        >
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"
                            ></path>
                        </svg>
                        <a
                            href="#"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
                        >
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 3-->
                </div>
                <!--end::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 4-->
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <svg
                            class="small-box-icon"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                        >
                            <path
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                            ></path>
                            <path
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                            ></path>
                        </svg>
                        <a
                            href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                        >
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 4-->

                </div>
                <!--end::Col-->
            </div>

            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->

    </main>

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify (inputElm);
    </script>

@endsection
