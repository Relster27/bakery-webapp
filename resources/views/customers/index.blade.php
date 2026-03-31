@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="actions">
            <div>
                <h1>Customers</h1>
                <p class="muted">Customers can come from manual owner input or from public pre-orders.</p>
            </div>
            <a class="button-inline" href="{{ route('customers.create') }}">Add Customer</a>
        </div>
    </section>

    <section class="card">
        @if ($customers->isEmpty())
            <p class="muted">No customers yet.</p>
        @else
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email ?: '-' }}</td>
                        <td>{{ $customer->phone ?: '-' }}</td>
                        <td><a href="{{ route('customers.edit', $customer) }}">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection
