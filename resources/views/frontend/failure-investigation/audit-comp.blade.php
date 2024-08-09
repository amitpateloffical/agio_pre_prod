@forelse($audit as $audits => $dataDemo)
                            <tr>
                                <td>{{ $dataDemo && !isset($filter_request) ? ($audit->currentPage() - 1) * $audit->perPage() + $audits + 1 : 'Not Applicable' }}</td>
                                <td>
                                    <div><strong>Changed From :</strong>{{ $dataDemo->change_from }}</div>
                                </td>
                                <td>
                                    <div><strong>Changed To :</strong>{{ $dataDemo->change_to }}</div>
                                </td>
                                <td>
                                    <div>
                                        <strong> Data Field Name :</strong>
                                        {{ $dataDemo->activity_type ? $dataDemo->activity_type : 'Not Applicable' }}
                                    </div>
                                    <div style="margin-top: 5px;">
                                        @if($dataDemo->activity_type == "Activity Log")
                                            <strong>Change From :</strong>{{ $dataDemo->change_from ? $dataDemo->change_from : 'Not Applicable' }}
                                        @else
                                            <strong>Change From :</strong>{{ $dataDemo->previous ? $dataDemo->previous : 'Not Applicable' }}
                                        @endif
                                    </div>
                                    <br>
                                    <div>
                                        @if($dataDemo->activity_type == "Activity Log")
                                            <strong>Change To :</strong>{{ $dataDemo->change_to ? $dataDemo->change_to : 'Not Applicable' }}
                                        @else
                                            <strong>Change To :</strong>{{ $dataDemo->current ? $dataDemo->current : 'Not Applicable' }}
                                        @endif
                                    </div>
                                    <div style="margin-top: 5px;">
                                        <strong>Change Type :</strong>{{ $dataDemo->action_name ? $dataDemo->action_name : 'Not Applicable' }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong> Action Name :</strong>{{ $dataDemo->action ? $dataDemo->action : 'Not Applicable' }}
                                    </div>
                                </td>
                                <td>
                                    <div><strong> Peformed By :</strong>{{ $dataDemo->user_name ? $dataDemo->user_name : 'Not Applicable' }}
                                    </div>
                                    <div style="margin-top: 5px;"> <strong>Performed On :</strong>{{ $dataDemo->created_at ? $dataDemo->created_at : 'Not Applicable' }}
                                    </div>
                                    <div style="margin-top: 5px;"><strong> Comments :</strong>{{ $dataDemo->comment ? $dataDemo->comment : 'Not Applicable' }}</div>
                                </td>
                            </tr>
@empty 
   <h4 class="text-center font-weight-bold">No Search Result Found</h4>

@endforelse