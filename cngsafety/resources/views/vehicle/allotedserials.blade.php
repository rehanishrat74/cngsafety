@extends('layouts.cngappdtpicker')
@section('lefttree')
                    <ul class='wraplist'>   

                        <!--<li class='menusection'>Main</li>

                    <?php if (Auth::user()->regtype!="hdip") {?>
                        <li class=""> 
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                    <?php }?>   -->                  

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            if ($node->functionname=="Stickers Management")
                            {
                                $highlightclass="open"; //highlight background
                            } else {$highlightclass="";}

                            ?>
                            <li class="{{$highlightclass}}"> 
                                <a href="/{{$node->routename}}">
                                    <i class="fa {{$node->iconClass}}"></i>
                                    <span class="title">{{$node->functionname}}</span>
                                </a>
                            </li> 

                        @endforeach                        




<!-- left tree categories -------4-lefttreecategories.txt-------------------------------->          
                    </ul>
@endsection

@section('content')
<script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 

                <section class="wrapper main-wrapper row" style=''>

                    <div class='col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Stickers Management</h1><!-- PAGE HEADING TAG - END -->                            </div>

                            <div class="float-right d-none">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="index.html"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <li>
                                        <a href="uni-professors.html">Professors</a>
                                    </li>
                                    <li class="active">
                                        <strong>Add Professor</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <!-- MAIN CONTENT AREA STARTS -->
                    <div class="col-12" >
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">Stickers Management</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">

                                <div class="form-group row "  > <!-- style="border-style: solid;"-->
                                    <div class="col-12" >
                                        <!-- msdsg div -->
                                        <div class="controls">
                                            @if(session()->has('message'))
                                                <div class="alert alert-success">
                                                    {{ session()->get('message') }}
                                                </div>
                                            @endif                                                                
                                        </div>

                                    </div><!-- end of msg div -->

                                    <div class="col-6" >
                                          <form id="saveStickers" action ="{{route('saveStickers')}}" method="post">
                                            {{ csrf_field() }}

                                            <div class="col-12" >
                                                <div class="form-group row">
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Unalloted Stickers</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">

                                                                <select class="form-control" id ="batch" name="batch">
                                                                    @foreach ($batches as $batch)
                                                                    <option value="<?php echo $batch->batchid;?>"><?php echo $batch->filename;?></option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                </div> <!--  end of first row-->

                                                <div class="form-group row" >
                                                    <div class="col-6">
                                                        <div class="controls">
                                                           <label class="form-label">Allote Stickers to Workshop</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="controls">
                                                            <select class="form-control" id ="workshop" name="workshop">
                                                            @foreach ($workshops as $workshop)
                                                            <option value="<?php echo $workshop->email;?>"><?php echo $workshop->name;?></option>
                                                                    @endforeach
                                                            </select>            
                                                        </div>                                                
                                                    </div>
                                                </div> <!-- end of second row -->
                                                <div class="form-group row" >
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary">Transfer</button>
                                                    </div>
                                                </div> <!-- end of third row -->


                                            </div>                                            
                                        </form>
                                    </div> <!-- end of left col -->

                                     <div class="col-6" >
                                        <form method="POST" action="{{ route('showUploadFile') }}" enctype="multipart/form-data" >
                                          {{ csrf_field() }}
                                                      <div class="input-group">
                                                          <span class="input-group-btn">
                                                              <span class="btn btn-default btn-file">
                                                                   <input type="file" id="uploadserials" 
                                                                   name="uploadserials">
                                                              </span>
                                                          </span>        
                                                          <button type="submit" class="btn btn-primary">upload</button>
                                                      </div>                                          

                                        </form>
                                    </div>
                                    

                                </div> <!-- end of first body row-->


                            </div>  <!-- end of content body -->
                        </section>
                    </div>  <!-- end of Main Content Area Col12-->
                </section> <!-- end of main wrapper -->




@endsection