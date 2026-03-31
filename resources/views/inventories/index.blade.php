@extends('layouts.app')

@section('content')
    <section class="hero">
        <h1>Inventory</h1>
        <p class="muted">This page manages stock quantities and reorder levels for each product.</p>
    </section>

    <section class="card">
        @if ($inventories->isEmpty())
            <p class="muted">Inventory will appear after you create products.</p>
        @else
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Current Stock</th>
                    <th>Reorder Level</th>
                    <th>Update</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($inventories as $inventory)
                    <tr>
                        <td>
                            <strong>{{ $inventory->product?->name }}</strong><br>
                            <span class="muted">{{ $inventory->product?->category }}</span>
                        </td>
                        <td>{{ $inventory->quantity_on_hand }}</td>
                        <td>{{ $inventory->reorder_level }}</td>
                        <td>
                            <form action="{{ route('inventories.update', $inventory) }}" method="POST" class="form-grid">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label for="quantity_on_hand_{{ $inventory->id }}">Stock</label>
                                    <input id="quantity_on_hand_{{ $inventory->id }}" name="quantity_on_hand" type="number" min="0" value="{{ $inventory->quantity_on_hand }}" required>
                                </div>
                                <div>
                                    <label for="reorder_level_{{ $inventory->id }}">Reorder</label>
                                    <input id="reorder_level_{{ $inventory->id }}" name="reorder_level" type="number" min="0" value="{{ $inventory->reorder_level }}" required>
                                </div>
                                <div style="align-self: end;">
                                    <button class="button-inline" type="submit">Save</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection
