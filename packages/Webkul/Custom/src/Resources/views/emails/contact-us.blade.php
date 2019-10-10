@component('shop::emails.layouts.master')
    <div class="section-content">
        <div class="table mb-20">
            <table style="overflow-x: auto; border-collapse: collapse;
            border-spacing: 0;width: 100%">
                <thead>
                    <tr style="background-color: #f2f2f2">
                        @foreach ($data as $key => $value)
                            <th style="text-align: left;padding: 8px">{{ $key }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        @foreach ($data as $key => $value)
                            <td style="text-align: left;padding: 8px">{{ $value ?? "---" }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endcomponent