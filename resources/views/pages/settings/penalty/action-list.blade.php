<div>
    <div class="table-responsive d-lg-block d-md-block  custom-data-table-wrapper2">
        {{-- <button onclick="clickToDownloadAll()" class="btn btn-primary">Download All Notice</button> --}}
        <table class="table mb-0 table-bordered custom-data-table">
            <thead>
                <tr class="userDatatable-header">
                    <th>
                        <span class="userDatatable-title">SL</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Order No</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Installment No</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Notice No</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Due Date</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Type</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Courier</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">View Date</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Action</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penalties as $key => $value)
                    <tr>
                        <td><div class="userDatatable-content">{{ $key + 1 }}</div></td>
                        <td>{{ $value->order_no ?? 'N/A' }}</td>
                        <td>{{ $value->installment_no ?? 'N/A' }}</td>
                        <td><div class="userDatatable-content">{{ $value->notice_no ?? 'N/A' }}</div></td>
                        <td><div class="userDatatable-content">{{ $value->due_date ? Carbon\Carbon::parse($value->due_date)->format('d F Y') : 'N/A' }}</div></td>
                        <td><div class="userDatatable-content">{{ $value->type ?? 'N/A' }}</div></td>
                        <td>
                            <div class="userDatatable-content--subject status-check">
                                @if($value->action == 0)
                                <select name="status" class="form-control status" data-id="{{ $value->id }}">
                                    <option value="pending" {{ $value->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="yes" {{ $value->status == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ $value->status == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                                @else
                                    @if($value->status == 'pending')
                                        <p class="bg-warning">Pending</p>
                                    @elseif($value->status == 'yes')
                                        <p class="bg-primary" style="opacity: 0.65;">Yes</p>
                                    @elseif($value->status == 'no')
                                        <p class="bg-danger" style="opacity: 0.65;">No</p>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td><div class="userDatatable-content">{{ $value->status_date ? Carbon\Carbon::parse($value->status_date)->format('d F Y') : 'N/A' }}</div></td>
                        <td>
                            <ul class="mb-0 d-flex flex-wrap justify-content-center gap-1">
                                <li class="d-flex align-items-center flex-column gap-1">
                                    <a style="white-space: nowrap" class="btn btn-info btn-sm w-100 d-block" href="{{ route('penalty.notice' , $value->id) }}" title="View details" target="_blank">Download</a>
                                </li>
                                @if(optional(optional($value->installment)->hire_purchase)->id)
                                    <li class="d-flex align-items-center flex-column gap-1">
                                        <a style="white-space: nowrap" class="btn btn-primary btn-sm w-100 d-block"
                                        href="{{ url('product_details/' . $value->installment->hire_purchase->id) }}"
                                        title="View details" target="_blank">
                                            View details
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pt-2">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Create the outer div for the table top scrollbar
        let $parentDivForTableTopScrollBar = $('<div></div>').addClass('custom-data-table-wrapper1 sticky-top');

        // Create the inner div for the table top scrollbar
        let $innerDivForTableTopScrollBar = $('<div></div>').addClass('custom-data-table-top-scrollbar');

        // Append the inner div to the outer div
        $parentDivForTableTopScrollBar.append($innerDivForTableTopScrollBar);

        // Insert the outer div before the .custom-data-table-wrapper2 element
        let $customDataTableWrapper2 = $('.custom-data-table-wrapper2');
        $parentDivForTableTopScrollBar.insertBefore($customDataTableWrapper2);

        let $customDataTableWrapper1 = $('.custom-data-table-wrapper1');

        // Add a scroll event listener to customDataTableWrapper1
        $customDataTableWrapper1.on('scroll', function() {
            $customDataTableWrapper2.scrollLeft($customDataTableWrapper1.scrollLeft());
        });

        // Add a scroll event listener to customDataTableWrapper2
        $customDataTableWrapper2.on('scroll', function() {
            $customDataTableWrapper1.scrollLeft($customDataTableWrapper2.scrollLeft());
        });

        let $customDataTable = $('.custom-data-table');
        let customDataTableWidth = $customDataTable.outerWidth();
        $('.custom-data-table-top-scrollbar').css('width', customDataTableWidth + 'px');
    });

    /* function clickToDownloadAll() {
        const ids = [1, 2, 3, 4];

        let delay = 500;

        ids.forEach((id, index) => {
            setTimeout(() => {
                let url = "{{ route('penalty.notice', ':id') }}".replace(':id', id);

                const a = document.createElement('a');
                a.href = url;
                a.download = "";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);

            }, index * delay);
        });
    } */
</script>