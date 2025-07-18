@section('css')
    <style>
        #channelSyncLogResultsModal .error {
            max-width: 100px;
        }

        #channelSyncLogResultsModal .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 0rem;
        }
    </style>
@endsection

<div class="table-responsive">
    {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered select-checkbox']) !!}
</div>

<div class="modal fade" id="channelSyncLogResultsModal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Resultados</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="channel-sync-log-results"></div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function() {
            var selected = [];

            $("#dataTableBuilder tbody").on("click", "tr", function() {
                var id = this.id;
                var index = $.inArray(id, selected);

                index === -1 ? selected.push(id) : selected.splice(index, 1);

                $(this).toggleClass("selected");
            });

            $("#channelSyncLogResultsModal").on("show.bs.modal", function(event) {
                var button = $(event.relatedTarget);
                var logId = button.data("log-id");

                window.mountComponent("ChannelSyncLogResult", "channel-sync-log-results", { logId });
            });
        });
    </script>
@endsection
