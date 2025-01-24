@if (flash()->message)
    <div class="modal modal-blur fade alert-dialog" id="modal-{{ flash()->class }}" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-{{ flash()->class }}"></div>
            <div class="modal-body text-center py-4">
                
                <!-- SVG icon code with class="mb-2 text-green icon-lg" -->
                @if(flash()->class == "danger")
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle mb-2 text-red icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 9v2m0 4v.01"></path>
                        <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
                    </svg>
                @elseif(flash()->class == "success")
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle mb-2 text-blue icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="12" r="9"></circle>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        <polyline points="11 12 12 12 12 16 13 16"></polyline>
                    </svg>
                @endif

                <?php
                    $message = explode('|', flash()->message);
                ?>
                <h3>{{$message[0]}}</h3>
                @if(count($message)>1)
                    <div class="text-muted">
                        {{$message[1]}}
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn btn-{{ flash()->class }} w-100" data-bs-dismiss="modal">
                            Close
                        </a></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endif