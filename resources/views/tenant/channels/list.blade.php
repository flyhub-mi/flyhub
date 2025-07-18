<div class="row">
    @foreach ($channelGroups as $group => $channels)
        <div class="col-12 col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">
                        {{ $group }}
                    </span>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        @foreach ($channels as $name => $channel)
                            <div class="col-sm-12 col-lg-6 col-xl-4">
                                <div class="small-box bg-white mb-2">
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon bg-primary">
                                            Novo
                                        </div>
                                    </div>
                                    <div class="inner align-items-center">
                                        <img src="{{ asset('images/channels/' . strtolower($name) . '.png') }}"
                                            class="img-fluid">
                                    </div>

                                    @if (is_null($channel))
                                        <a href="{{ route('channels.create', ['activate' => $name]) }}"
                                            class="small-box-footer">
                                            Ativar <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('channels.edit', $channel) }}" class="small-box-footer">
                                            Configurar <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
