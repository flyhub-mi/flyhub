<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Status:', 'status') !!}
    {!! html()->text('status', null)->class('form-control') !!}
</div>

<!-- Total Qty Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Total Qty:', 'total_qty') !!}
    {!! html()->number('total_qty', null)->class('form-control') !!}
</div>

<!-- Total Weight Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Total Weight:', 'total_weight') !!}
    {!! html()->number('total_weight', null)->class('form-control') !!}
</div>

<!-- Carrier Code Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Carrier Code:', 'carrier_code') !!}
    {!! html()->text('carrier_code', null)->class('form-control') !!}
</div>

<!-- Carrier Title Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Carrier Title:', 'carrier_title') !!}
    {!! html()->text('carrier_title', null)->class('form-control') !!}
</div>

<!-- Track Number Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! html()->label('Track Number:', 'track_number') !!}
    {!! html()->textarea('track_number', null)->class('form-control') !!}
</div>

<!-- Email Sent Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Email Sent:', 'email_sent') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('email_sent', 0) !!}
        {!! html()->checkbox('email_sent', '1', null) !!}
    </label>
</div>


<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Customer Id:', 'customer_id') !!}
    {!! html()->number('customer_id', null)->class('form-control') !!}
</div>

<!-- Customer Type Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Customer Type:', 'customer_type') !!}
    {!! html()->text('customer_type', null)->class('form-control') !!}
</div>

<!-- Order Id Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Order Id:', 'order_id') !!}
    {!! html()->number('order_id', null)->class('form-control') !!}
</div>

<!-- Inventory Source Id Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Inventory Source Id:', 'inventory_source_id') !!}
    {!! html()->number('inventory_source_id', null)->class('form-control') !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! html()->submit('Salvar')->class('btn btn-primary') !!}
    <a href="{{ route('shipments.index') }}" class="btn btn-default">Cancelar</a>
</div>
