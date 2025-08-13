<div class="card-body p-0">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="t_selling-today-Source22" role="tabpanel"
                        aria-labelledby="t_selling-today-Source22-tab">
                        <div class="selling-table-wrap source_of_table selling-table-wrap--source">
                            <div class="table-responsive custom-data-table-wrapper2">
                                <table class="table table--default table-borderless custom-data-table">
                                    <thead class="source_of">
                                        <tr>
                                            <th class="text-start">Source</th>
                                            <th class="text-start">Open</th>
                                            <th class="text-start">Sell</th>
                                            <th class="text-start">Pending</th>
                                            <th class="text-start">Close</th>
                                            <th style="padding-right: 60px" class="text-start ">Total</th>
                                            <th class="text-right">Conversion Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($enquiry_sources as  $key=>$enquiry_source)
                                        @php
                                           $user_id = Auth::user()->id;
                                           $open = App\Models\Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('source_parent',$enquiry_source->id);
                                            $sale = App\Models\Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('source_parent',$enquiry_source->id);
                                            $pending = App\Models\Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('source_parent',$enquiry_source->id);
                                            $close = App\Models\Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('source_parent',$enquiry_source->id);
                                             $total = App\Models\Enquery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('source_parent',$enquiry_source->id);
                                           if (Auth::user()->role_id == 2) {
                                             $open->where('assign', $user_id);
                                             $sale->where('assign', $user_id);
                                             $pending->where('assign', $user_id);
                                             $close->where('assign', $user_id);
                                             $total->where('assign', $user_id);
                                           }elseif(Auth::user()->role_id == 3){
                                                $showroom_id = Auth::user()->showroom_id;
                                                $open->where('showroom_id', $showroom_id);
                                                $sale->where('showroom_id', $showroom_id);
                                                $pending->where('showroom_id', $showroom_id);
                                                $close->where('showroom_id', $showroom_id);
                                                $total->where('showroom_id', $showroom_id);
                                           }elseif(Auth::user()->role_id == 6){
                                               $created_by = Auth::user()->id;
                                               $open->where('created_by', $created_by);
                                               $sale->where('created_by', $created_by);
                                               $pending->where('created_by', $created_by);
                                               $close->where('created_by', $created_by);
                                              $total->where('created_by', $created_by);
                                           }
                                           if(request('Showroom')){
                                              $open->where('showroom_id', request('Showroom'));
                                              $sale->where('showroom_id', request('Showroom'));
                                              $pending->where('showroom_id', request('Showroom'));
                                              $close->where('showroom_id', request('Showroom'));
                                              $total->where('showroom_id', request('Showroom'));
                                           }

                                           $total = $total->count();
                                           $open = $open->where('enquiry_status',$enquiry_status['open'])->count();
                                           $sale = $sale->where('enquiry_status',$enquiry_status['sale'])->count();
                                           $close = $close->whereIn('enquiry_status',$new_close_status)->count();

                                           $pending = $pending->where('enquiry_status',$enquiry_status['pending'])->count();


                                            if ($total <= 0) {
                                                $total = 1;
                                            }

                                        @endphp
                                        <tr>
                                            <td class="text-start">
                                                <div class="selling-product-img d-flex align-items-center">

                                                    <span>{{ $enquiry_source->name  }}</span>
                                                </div>
                                            </td>
                                            <td class="text-start">{{  $open }}</td>
                                            <td class="text-start">{{  $sale }}</td>
                                            <td class="text-start">{{ $pending }}</td>
                                            <td class="text-start">{{ $close }}</td>

                                            <td class="text-start">
                                               {{ $total  }}
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex align-center justify-content-end">
                                                    @php
                                                     $conversion =  number_format(($sale / $total) * 100, 0);


                                                    @endphp
                                                    <div class="ratio-percentage me-15">{{ $conversion }}%</div>
                                                    <div class="progress-wrap mb-0">
                                                        <div class="progress">
                                                            <div class="progress-bar @if($conversion >= 50 ) bg-success @else bg-secondary @endif  " role="progressbar"
                                                                style="width: {{ $conversion }}%;" aria-valuenow="18"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                     @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
