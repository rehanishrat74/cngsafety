@extends('layouts.print')
@section('content')

                                        <table >
                                           
                                            <thead>
                                               <tr>
                                               
                                                 <th>Record</th>
                                                 <th>Plate</th>
                                                 <th>Engine</th>
                                                 <th>Chasis</th>
                                                 <th>Sticker</th>
                                                 <th>Make</th>
                                                 <th>Type</th>     
                                                 <th>Owner</th>     
                                                 <th>NIC</th>     
                                                 <th>Cell</th>     
                                                 <th>Address</th>     
                                                 <th>Status</th>     
                                                 <th>Inspection</th>     

                                               </tr>

                                            </thead>


                                            <tbody>
                                                 @foreach ($vehicles as $vehicle)                               
                                                   <tr>
                                                     <td>{{$vehicle->Record_no}}</td>
                                                     <td>{{$vehicle->Registration_no}}</td>
                                                     <td>{{$vehicle->Engine_no}}</td>
                                                     <td>{{$vehicle->Chasis_no}}</td>
                                                     <td>{{$vehicle->StickerSerialNo}}</td>
                                                     <td>{{$vehicle->Make_type}}</td>
                                                     <td>{{$vehicle->businesstype}}</td>
                                                     <td>{{$vehicle->Owner_name}}</td>
                                                     <td>{{$vehicle->OwnerCnic}}</td>
                                                     <td>{{$vehicle->Cell_No}}</td>
                                                     <td>{{$vehicle->Address}}</td>
                                                     <td>{{$vehicle->Inspection_Status}}</td>
                                                     <td>{{$vehicle->InspectionDate}}</td>

                                                   </tr>
                                                 @endforeach  

                                            </tbody>
                                        </table>






@endsection