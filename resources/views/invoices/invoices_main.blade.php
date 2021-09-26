<div class="row">
    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('canceledArchive'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('canceledArchive') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Archived'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Archived') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!--div-->
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                @can('اضافة فاتورة')
                    <a href="invoices/create" class="btn btn-primary btn-inline-block">إضافة فاتورة</a>

                @endcan
                @can('تصدير EXCEL')
                    <a href="export_invoice" class="btn btn-success btn-inline-block">تصدير excel</a>

                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap text-center" data-page-length="50">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">تاريخ الفاتورة</th>

                                <th class="border-bottom-0">تاريخ الإستحقاق</th>

                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">تاريخ الدفع</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">نسبة الضريبة</th>
                                <th class="border-bottom-0">قيمة الضريبة</th>
                                <th class="border-bottom-0">الإجمالى</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                @php
                                    
                                    static $i = 1;
                                @endphp

                                <tr>
                                    <td><a class="btn btn-primary btn-block text-light"
                                            href="{{ url('invoicedetails') }}/{{ $invoice->id }}">{{ $i }}</a>
                                    </td>

                                    <td>{{ $invoice->invoice_Date }}</td>
                                    <td>{{ $invoice->Due_date }}</td>

                                    <td>{{ $invoice->product }}</td>
                                    <td>{{ $invoice->section->section_name }}</td>
                                    <td>{{ $invoice->payment_date }}</td>
                                    <td>{{ $invoice->Discount }}</td>
                                    <td>{{ $invoice->Rate_VAT }}</td>
                                    <td>{{ $invoice->Value_VAT }}</td>
                                    <td>{{ $invoice->Total }}</td>
                                    <td>
                                        @if ($invoice->value_status == 1)
                                            <span
                                                class="text-success font-weight-bold">{{ $invoice->status->name }}</span>
                                        @elseif ($invoice->value_status == 2)
                                            <span
                                                class="text-danger font-weight-bold">{{ $invoice->status->name }}</span>
                                        @else
                                            <span
                                                class="text-warning font-weight-bold">{{ $invoice->status->name }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $invoice->note }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                class="btn ripple btn-primary" data-toggle="dropdown"
                                                id="dropdownMenuButton" type="button">العمليات <i
                                                    class="fas fa-caret-down ml-1"></i></button>
                                            <div class="dropdown-menu tx-13 text-dark">
                                                @if ($invoice->deleted_at === null)
                                                    @can('تعديل الفاتورة')


                                                        <a class="dropdown-item"
                                                            href="{{ url('editinvoice') }}/{{ $invoice->id }}"><i
                                                                class="fas fa-edit text-primary"></i> تعديل
                                                            الفاتورة</a>
                                                    @endcan
                                                @endif

                                                @can('حذف الفاتورة')


                                                    <a class="dropdown-item" href="#"
                                                        data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                        data-target="#delete_invoice"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                        الفاتورة</a>
                                                @endcan
                                                @can('تغير حالة الدفع')


                                                    <a class="dropdown-item"
                                                        href="{{ URL::route('StatusShow', [$invoice->id]) }}"> <i
                                                            class="fas fa-money-bill text-success"></i>&nbsp;&nbsp;تغيير
                                                        حالة
                                                        الفاتورة</a>
                                                @endcan
                                                @if ($invoice->deleted_at === null)
                                                    @can('ارشفة الفاتورة')


                                                        <a class="dropdown-item" href="#"
                                                            data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                            data-target="#soft_delete_invoice"
                                                            href="{{ URL::route('Archive') }}"> <i
                                                                class="fas fa-money-bill text-warning"></i>&nbsp;&nbsp; نقل
                                                            إلى
                                                            الأرشيف</a>
                                                    @endcan

                                                @else
                                                    <a class="dropdown-item"
                                                        href="{{ URL::route('restore', $invoice->id) }}"> <i
                                                            class="fas fa-money-bill text-warning"></i>&nbsp;&nbsp;
                                                        إلغاء الأرشفة</a>
                                                @endif
                                                @can('طباعةالفاتورة')


                                                    <a class="dropdown-item" href="/printInvoice/{{ $invoice->id }}">
                                                        <i class="text-info fas fa-print"></i>&nbsp;&nbsp; طباعة فاتورة</a>
                                                @endcan
                                            </div>
                                        </div>

                                    </td>
                                    @php
                                        $i++;
                                    @endphp
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <form action="{{ route('invoices.destroy', [1]) }}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                        </div>
                        <div class="modal-body">
                            هل انت متاكد من عملية الحذف ؟
                            <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="soft_delete_invoice" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">نقل إلى الأرشيف</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <form action="{{ route('Archive') }}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                        </div>
                        <div class="modal-body">
                            هل انت متاكد من عملية النقل ؟
                            <input type="hidden" name="invoice_id" id="invoice_id2" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->
    </div><!-- end content -->
</div><!-- end row -->
