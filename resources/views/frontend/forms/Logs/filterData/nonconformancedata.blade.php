@forelse($nonconform as $non)
<tr>
                                            
                                            <td>{{$loop->index=1}}</td>
                                            <td>{{$non->initiation_date}}<td>
                                            <td>{{$non->initiator?$non->initiator->name:'-'}}</td>
                                            <td>{{$non->division?$division->name:'-'}}</td>
                                            <td>{{$non->Initiator_Group}}</td>
                                            <td>{{$non->short_description}}</td>
                                            <td>{{$non->record_number}}</td>
                                            <td>{{$non->Product_name}}</td>
                                            <td>{{$non->due_date}}</td>
                                            <td>{{$non->no_of_extension}}</td>
                                            <td>{{$non->closure_date}}</td>
                                            <td><{{$non->status}}/td>
                                            
                                        </tr>
@empty
<tr>
    <th>Data Not Found</th>
</tr>
@endforelse