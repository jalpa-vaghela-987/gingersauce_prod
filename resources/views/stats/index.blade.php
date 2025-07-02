<table width="100%" border="1" style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif">
    <tr style="background-color: #ccc">
        <th width="100">Date</th>
        <th width="100">Number of Registrants</th>
        <th width="150">Number official books</th>
        <th width="150">Number of Completed books</th>
        @for($i=1; $i<=25; $i++)
            <th>#{{ $i }}</th>
        @endfor
        <th>Num of invoices</th>
        <th>Sum of invoices</th>
        <th>Existing subscription</th>
        <th>New subscription</th>
    </tr>

    @foreach ($results as $row)
        <tr>
            <td>{{ \Carbon\Carbon::parse($row['date'])->format('d/m/Y') }}</td>
            <td>{{ $row['users'] ?: '' }}</td>
            <td>{{ \Arr::get($row['books'], 'public') }}</td>
            {{-- <td>{{ \Arr::get($row['books'], 'draft') }}</td> --}}
            <td>{{ \Arr::get($row['books'], 'pdf') }}</td>
            @for($i=1; $i<=25; $i++)
                <td>{{ \Arr::get($row['books'], $i) }}</th>
            @endfor
            <td>{{ \Arr::get($row['invoices'], 'invoices') }}</td>
            <td>{{ \Arr::get($row['invoices'], 'invoices_sum') }}</td>
            <td>{{ \Arr::get($row['existing_subscriptions'], 'existing_subscriptions') }}</td>
            <td>{{ \Arr::get($row['new_subscriptions'], 'new_subscriptions') }}</td>
        </tr>
    @endforeach

</table>
