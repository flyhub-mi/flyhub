@extends('tenant.layout')

@section('content')
<section class="content-header">
    <h1>
        Shipment
    </h1>
</section>
<div class="content">
    <div class="card card-primary">
        <div class="card-body">
            <div class="row" style="padding-left: 20px">
                <!-- Status Field -->
                <div class="form-group">
                    {!! html()->label('Status:', 'status') !!}
                    <p>{{ $shipment->status }}</p>
                </div>

                <!-- Total Qty Field -->
                <div class="form-group">
                    {!! html()->label('Total Qty:', 'total_qty') !!}
                    <p>{{ $shipment->total_qty }}</p>
                </div>

                <!-- Total Weight Field -->
                <div class="form-group">
                    {!! html()->label('Total Weight:', 'total_weight') !!}
                    <p>{{ $shipment->total_weight }}</p>
                </div>

                <!-- Carrier Code Field -->
                <div class="form-group">
                    {!! html()->label('Carrier Code:', 'carrier_code') !!}
                    <p>{{ $shipment->carrier_code }}</p>
                </div>

                <!-- Carrier Title Field -->
                <div class="form-group">
                    {!! html()->label('Carrier Title:', 'carrier_title') !!}
                    <p>{{ $shipment->carrier_title }}</p>
                </div>

                <!-- Track Number Field -->
                <div class="form-group">
                    {!! html()->label('Track Number:', 'track_number') !!}
                    <p>{{ $shipment->track_number }}</p>
                </div>

                <!-- Email Sent Field -->
                <div class="form-group">
                    {!! html()->label('Email Sent:', 'email_sent') !!}
                    <p>{{ $shipment->email_sent }}</p>
                </div>

                <!-- Customer Id Field -->
                <div class="form-group">
                    {!! html()->label('Customer Id:', 'customer_id') !!}
                    <p>{{ $shipment->customer_id }}</p>
                </div>

                <!-- Customer Type Field -->
                <div class="form-group">
                    {!! html()->label('Customer Type:', 'customer_type') !!}
                    <p>{{ $shipment->customer_type }}</p>
                </div>

                <!-- Order Id Field -->
                <div class="form-group">
                    {!! html()->label('Order Id:', 'order_id') !!}
                    <p>{{ $shipment->order_id }}</p>
                </div>

                <!-- Inventory Source Id Field -->
                <div class="form-group">
                    {!! html()->label('Inventory Source Id:', 'inventory_source_id') !!}
                    <p>{{ $shipment->inventory_source_id }}</p>
                </div>

                <a href="{{ route('shipments.index') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
