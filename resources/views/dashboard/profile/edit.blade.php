@extends('layout/dashboard');

@section('title','Edit Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
@endsection

@section('content')

    {{-- show errors --}}
    <x-alert />


    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-white">
        @csrf
        @method('patch')
        <h4 class="mb-4">Update Profile</h4>

        {{-- First Name --}}
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $user->profile->first_name ?? '') }}" required>
        </div>

        {{-- Last Name --}}
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->profile->last_name ?? '') }}" required>
        </div>

        {{-- Birthday --}}
        <div class="mb-3">
            <label for="birthday" class="form-label">Birthday</label>
            <input type="date" name="birthday" id="birthday" class="form-control" value="{{ old('birthday', $user->profile->birthday ?? '') }}" required>
        </div>

        {{-- Gender --}}
        <div class="mb-3">
            <label class="form-label"> Gender </label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" {{ old('gender', $user->profile->gender ?? '') === 'male' ? 'checked' : '' }}>
                <label class="form-check-label" for="genderMale">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" {{ old('gender', $user->profile->gender ?? '') === 'female' ? 'checked' : '' }}>
                <label class="form-check-label" for="genderFemale">Female</label>
            </div>
        </div>

        {{-- Street Address --}}
        <div class="mb-3">
            <label for="street_address" class="form-label">Street Address</label>
            <input type="text" name="street_address" id="street_address" class="form-control" value="{{ old('street_address', $user->profile->street_address ?? '') }}" required>
        </div>

        {{-- City --}}
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $user->profile->city ?? '') }}" required>
        </div>

        {{-- State --}}
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" name="state" id="state" class="form-control" value="{{ old('state', $user->profile->state ?? '') }}">
        </div>

        {{-- Postal Code --}}
        <div class="mb-3">
            <label for="postal_code" class="form-label">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code', $user->profile->postal_code ?? '') }}">
        </div>

        {{-- Country --}}
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select name="country" id="country" class="form-control">
                @foreach ($countries as $code => $name)
                    <option value="{{ $code }}" {{ old('country', $user->profile->country ?? '') === $code ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

{{--        <div class="col-md-4">--}}
{{--            <x-select name="country" :options="$countries" lable="Country" :selected="$user->profile->country" />--}}
{{--        </div>--}}


        {{-- Locale --}}
        <div class="mb-4">
            <label for="locale" class="form-label">Locale</label>
            <select name="locale" id="locale" class="form-control">
                @foreach ($locales as $code => $name)
                    <option value="{{ $code }}" {{ old('locale', $user->profile->locale ?? '') === $code ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>

    <div class="d-flex justify-content-center">
        <span class="fw-bold me-1">Last Active:</span>
        @if($user->last_active_at)
            <span>{{ $user->last_active_at->format('F j, Y \a\t g:i A') }}</span>
        @else
            <span class="text-muted">Never active</span>
        @endif
    </div>


    </main>

@endsection
