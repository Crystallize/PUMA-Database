  <?php $this->load->view('header'); ?>
  <!-- ======= Sidebar ======= -->
  <?php //$this->load->view('sidebar');  ?>
  <style>
.dropbtn {
  background-color: #008080;
  color: white;
  padding: 10px;
  font-size: 15px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content li {
  color: black;
  padding: 8px 12px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/plug-ins/1.13.1/features/searchHighlight/dataTables.searchHighlight.css">
  <!-- End Sidebar-->

  <main id="main" class="main" style="margin-left:0px;">
    
    <div class="alert alert-danger" role="alert">
      Please provide feedback for PUMA Database <a href="https://forms.office.com/pages/responsepage.aspx?id=48TPkEN-PUyFfmbfrxno_f888Njnt-VLq4hZRTyZKm1UNzJOVzZYWklUV0VWSFZQS1ExNjlFM1k5Ry4u" target="_blank" class="alert-link">Click Here</a>. Give it a click if you like.
    </div>
    <div class="pagetitle">
      <h1>Journal Records</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Records</li>
          <li class="breadcrumb-item active">General</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Total Journals 
                    <!-- <span>| Today</span> -->
                  </h5>

                  <div class="d-flex align-items-center"  style="font-size: 30px;">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <!-- <i class="bi bi-cart"></i> -->
                    </div>
                    <div class="ps-3">
                      <!-- <h6>145</h6> -->
                      <span class="text-success small pt-1 fw-bold"><?php echo $journal_data_count; ?></span> 
                      <!-- <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Filtered Journal
                    <!-- <span>| This Month</span> -->
                  </h5>

                  <div class="d-flex align-items-center"  style="font-size: 30px;">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <!-- <i class="bi bi-currency-dollar"></i> -->
                    </div>
                    <div class="ps-3">
                      <!-- <h6>$3,264</h6> -->
                      <span class="text-success small pt-1 fw-bold"><?php echo $filtered_count; ?></span> <span class="text-muted small pt-2 ps-1"></span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <!--<div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Export All 
                   <span>| This Year</span>
                  </h5>

                  <div class="d-flex align-items-center" style="font-size: 30px;">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                       <i class="bi bi-people"></i>
                    </div>
                    <div >
                       <h6>1244</h6>
                      <span class="text-danger  pt-1 fw-bold"><a href= ""><i class="bi bi-arrow-bar-down"></i></a></span> 

                    </div>
                  </div>

                </div>
              </div>

            </div> -->
            <!-- End Customers Card -->
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Filters</h5>

              <form class="row g-3" method="post" action="" id="form_search">
                <div class="col-md-5">
                  <select id="filter_option" class="form-select" name="filter_option" required>
                    <option selected="">Select Options</option>
                    <option value="Topic" <?php if($filter_option=='Topic'){ echo 'selected';} ?>>Topic</option>
                    <option value="In_Pubmed" <?php if($filter_option=='In_Pubmed'){ echo 'selected';} ?>>In PubMed</option>
                    <option value="counts" <?php if($filter_option=='counts'){ echo 'selected';} ?>>Counts</option>
                    <option value="PubMed_Start_Year" <?php if($filter_option=='PubMed_Start_Year'){ echo 'selected';} ?>>PubMed Start Year</option>
                    <option value="PubMed_End_Year" <?php if($filter_option=='PubMed_End_Year'){ echo 'selected';} ?>>PubMed End Year</option>
                    <option value="Archive_Coverage_Start_Year" <?php if($filter_option=='Archive_Coverage_Start_Year'){ echo 'selected';} ?>>Archive Coverage Start Year</option>
                    <option value="Archive_Coverage_END" <?php if($filter_option=='Archive_Coverage_END'){ echo 'selected';} ?>>Archive Coverage End Year</option>
                    <option value="Content" <?php if($filter_option=='Content'){ echo 'selected';} ?>>Content</option>
                    <option value="Login" <?php if($filter_option=='Login'){ echo 'selected';} ?>>Login</option>
                    <option value="Free_Pay" <?php if($filter_option=='Free_Pay'){ echo 'selected';} ?>>Free/Pay</option>
                    <option value="Language" <?php if($filter_option=='Language'){ echo 'selected';} ?>>Language</option>
                    <option value="MeSH" <?php if($filter_option=='MeSH'){ echo 'selected';} ?>>MeSH</option>
                    <option value="Indexed_NLM" <?php if($filter_option=='Indexed_NLM'){ echo 'selected';} ?>>Indexed NLM</option>
                    <option value="Indexed_Embase" <?php if($filter_option=='Indexed_Embase'){ echo 'selected';} ?>>Indexed Embase</option>
                    <option value="Indexed_Embase_NLM" <?php if($filter_option=='Indexed_Embase_NLM'){ echo 'selected';} ?>>Indexed Embase NLM</option>
                    <option value="Not_Indexed_NLM_and_Embase" <?php if($filter_option=='Not_Indexed_NLM_and_Embase'){ echo 'selected';} ?>>Not Indexed NLM and Embase</option>
                    <option value="Indexed_NLM_not_in_Embase" <?php if($filter_option=='Indexed_NLM_not_in_Embase'){ echo 'selected';} ?>>Indexed NLM not in Embase</option>

                    <!-- <option value="topic" <?php if($filter_option=='topic'){ echo 'selected';} ?>>Topic</option>
                    <option value="in_pubmed"  <?php if($filter_option=='in_pubmed'){ echo 'selected';} ?>>In PubMed</option>
                    <option value="counts"  <?php if($filter_option=='counts'){ echo 'selected';} ?>>Counts</option>
                    <option value="pubmed_start_year"  <?php if($filter_option=='pubmed_start_year'){ echo 'selected';} ?>>PubMed Start Year</option>
                    <option value="pubmed_end_year"  <?php if($filter_option=='pubmed_end_year'){ echo 'selected';} ?>>PubMed End Year</option>
                    <option value="archive_coverage_start_year"  <?php if($filter_option=='archive_coverage_start_year'){ echo 'selected';} ?>>Archive Coverage Start Year</option>
                    <option value="archive_coverage_end_year"  <?php if($filter_option=='archive_coverage_end_year'){ echo 'selected';} ?>>Archive Coverage End Year</option>
                    <option value="content"  <?php if($filter_option=='content'){ echo 'selected';} ?>>Content</option>
                    <option value="login"  <?php if($filter_option=='login'){ echo 'selected';} ?>>Login</option>
                    <option value="free_pay"  <?php if($filter_option=='free_pay'){ echo 'selected';} ?>>Free/Pay</option>
                    <option value="language" <?php if($filter_option=='language'){ echo 'selected';} ?>>Language</option>
                    <option value="mesh" <?php if($filter_option=='mesh'){ echo 'selected';} ?>>MeSH</option>
                    <option value="indexed_nlm" <?php if($filter_option=='indexed_nlm'){ echo 'selected';} ?>>Indexed NLM</option>
                    <option value="indexed_embase" <?php if($filter_option=='indexed_embase'){ echo 'selected';} ?>>Indexed Embase</option>
                    <option value="indexed_embase_nlm" <?php if($filter_option=='indexed_embase_nlm'){ echo 'selected';} ?>>Indexed Embase NLM</option>
                    <option value="not_indexed_nlm_and_embase" <?php if($filter_option=='not_indexed_nlm_and_embase'){ echo 'selected';} ?>>Not Indexed NLM and Embase</option>
                    <option value="indexed_nlm_not_in_embase" <?php if($filter_option=='indexed_nlm_not_in_embase'){ echo 'selected';} ?>>Indexed NLM not in Embase</option> -->
                  </select>
                </div>  
                <div class="col-md-5">
                  <input type="text" class="form-control" name="filter_value" id = "filter_value" value="<?php echo $filter_value; ?>" placeholder="Text to search">
                </div>
                
                <div class="col-md-2">
                  <div class="dropdown">
                    <button class="dropbtn" id="add_btn" value="ADD">ADD</button>
                    <div class="dropdown-content">
                      <li  id="add_with_and">Add with AND</li>
                      <li  id="add_with_or">Add with OR</li>
                      <li  id="add_with_not">Add with NOT</li>
                    </div>
                  </div>
                </div>

                <div class="col-md-10">
                  <textarea class="form-control" id="query_box" name="query_box"></textarea>
                </div>
                <div class="col-md-2">
                  <button type="submit" id="submit_form" class="btn btn-primary" >Submit</button>
                  <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                </div>
              </form>

            </div>
        </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Journal Records</h5>

              <!-- Default Table -->
              <table class="table table-striped table-bordered table-sm" id="example" style="width:100%;font-size:12px;">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    
                    <th scope="col">In Pubmed</th>
                    <th scope="col">Journal</th>
                    <th scope="col">Counts</th>
                    <th scope="col">URL</th>
                    <th scope="col">Archive Start Year</th>
                    <th scope="col">Archive End Year</th>
                    <th scope="col">Language</th>
                    <th scope="col">MeSH</th>

                    <th scope="col">Topic</th>
                    <th scope="col">NLM Id</th>
                    <th scope="col">Start Year</th>
                    <th scope="col">End Year</th>
                    <th scope="col">Pubmed Journal Status</th>
                    <th scope="col">Pubmed Start Year</th>
                    <th scope="col">Pubmed End Year</th>
                    <th scope="col">Medline Journal Status</th>
                    <th scope="col">Medline Start Year</th>
                    <th scope="col">Medline End Year</th>
                    <th scope="col">URL CNKI</th>
                    <th scope="col">URL CAOD</th>
                    <th scope="col">CAOD Coverage Start Year</th>
                    <th scope="col">CAOD Coverage End Year</th>
                    <th scope="col">Content</th>
                    <th scope="col">Login</th>
                    <th scope="col">Free/Pay</th>
                    <th scope="col">Notes</th>
                    <th scope="col">Print ISSN NLM</th>
                    <th scope="col">Electronic ISSN NLM</th>
                    <th scope="col">Linking ISSN NLM</th>
                    <th scope="col">Indexed NLM</th>
                    <th scope="col">Indexed Embase</th>
                    <th scope="col">Indexed Embase NLM</th>
                    <th scope="col">Not Indexed NLM and Embase</th>
                    <th scope="col">Indexed NLM not in Embase</th>
                    <th scope="col">PMC Journal Status</th>
                    <th scope="col">PMC Start Year</th>
                    <th scope="col">PMC End Year</th>
                    <th scope="col">PMC Free Access</th>
                    <th scope="col">PMC Journal URL</th>
                  </tr>
                </thead>
                <tbody>
                 
                  <?php $i=1;
                  foreach ($journal_data as $rec) {
                  ?>
                                  
                  <tr>
                    <th scope="row"><?php echo $i; ?></th>
                   
                    <td><?php echo ucfirst($rec->in_pubmed); ?></td>
                    <td><?php echo ucfirst($rec->journal); ?></td>
                    <td><?php echo $rec->counts; ?></td>
                    <td><?php echo ucfirst($rec->url); ?></td>
                    <td><?php echo $rec->archive_coverage_start_year; ?></td>
                    <td><?php echo $rec->archive_coverage_end_year; ?></td>
                    <td><?php echo $rec->language; ?></td>
                    <td><?php echo $rec->mesh; ?></td>

                    <td><?php echo $rec->topic; ?></td>
                    <td><?php echo $rec->nlm_id; ?></td>
                    <td><?php echo $rec->start_year; ?></td>
                    <td><?php echo $rec->end_year; ?></td>
                    <td><?php echo $rec->pubmed_journal_status; ?></td>
                    <td><?php echo $rec->pubmed_start_year; ?></td>
                    <td><?php echo $rec->pubmed_end_year; ?></td>
                    <td><?php echo $rec->medline_journal_status; ?></td>
                    <td><?php echo $rec->medline_start_year; ?></td>
                    <td><?php echo $rec->medline_end_year; ?></td>
                    <td><?php echo $rec->url_cnki; ?></td>
                    <td><?php echo $rec->url_caod; ?></td>
                    <td><?php echo $rec->caod_coverage_start_year; ?></td>
                    <td><?php echo $rec->caod_coverage_end_year; ?></td>
                    <td><?php echo $rec->content; ?></td>
                    <td><?php echo $rec->login; ?></td>
                    <td><?php echo $rec->free_pay; ?></td>
                    <td><?php echo $rec->notes; ?></td>
                    <td><?php echo $rec->print_issn_nlm; ?></td>
                    <td><?php echo $rec->electronic_issn_nlm; ?></td>
                    <td><?php echo $rec->linking_issn_nlm; ?></td>
                    <td><?php echo $rec->indexed_nlm; ?></td>
                    <td><?php echo $rec->indexed_embase; ?></td>
                    <td><?php echo $rec->indexed_embase_nlm; ?></td>
                    <td><?php echo $rec->not_indexed_nlm_and_embase; ?></td>
                    <td><?php echo $rec->indexed_nlm_not_in_embase; ?></td>
                    <td><?php echo $rec->pmc_journal_status; ?></td>
                    <td><?php echo $rec->pmc_start_year; ?></td>
                    <td><?php echo $rec->pmc_end_year; ?></td>
                    <td><?php echo $rec->pmc_free_access; ?></td>
                    <td><?php echo $rec->pmc_journal_URL; ?></td>

                  </tr>
                  <?php 
                  $i++;
                  }
                  ?>

                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php $this->load->view('footer'); ?>
  <!-- End Footer -->
  


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src ="//cdn.datatables.net/plug-ins/1.13.1/features/searchHighlight/dataTables.searchHighlight.min.js"></script>
    <script type="text/javascript" src="https://bartaz.github.io/sandbox.js/jquery.highlight.js"></script>
    <!-- <script src="<?php echo base_url() ?>assets/js/dataTables.searchHighlight.js"></script> -->
<script type="text/javascript">

$(document).ready(function () {
     var table = $('#example').DataTable({
        scrollX: true,
        mark: true,
         "lengthChange": false,
        searchHighlight: true,
        language: 
        {
          searchPlaceholder: "Search Journal Records"
        },
        dom: 'Bfrtip',
        buttons: [
            {
               extend:    'excelHtml5',
                text:      'Export Excel',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      'Export CSV',
                titleAttr: 'CSV'
            }
        ]
    });
     table.on( 'draw', function () {
        var body = $( table.table().body() );
 
        body.unhighlight();
        body.highlight( table.search() );  
    } );
});
//   $(document).ready( function () {
//     var table = $('#example').DataTable();
 
//     table.on( 'draw', function () {
//         var body = $( table.table().body() );
 
//         body.unhighlight();
//         body.highlight( table.search() );  
//     } );
// } );

  $('#add_with_and').click(function(){
    $("#add_btn").html('AND');
    $("#add_btn").attr('value', 'AND');
    var filter_option = $('#filter_option').val();
    var filter_value = $('#filter_value').val();
    var txt = $("#query_box").val(); 
    var queryBox = '';
    if(filter_option!='' && filter_value!='')
    {  
      if(txt)
      {
        var queryBox = txt+' AND (['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox); 
      }
      else
      {
        var queryBox = '(['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox);
      }      
    }  
  });

  $('#add_with_or').click(function(){
    $("#add_btn").html('OR');
    $("#add_btn").attr('value', 'OR');
    var filter_option = $('#filter_option').val();
    var filter_value = $('#filter_value').val();
    var txt = $("#query_box").val(); 
    var queryBox = '';
    if(filter_option!='' && filter_value!='')
    {  
      if(txt)
      {
        var queryBox = txt+' OR (['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox); 
      }
      else
      {
        var queryBox = '(['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox);
      }      
    }  
  });

  $('#add_with_not').click(function(){
    $("#add_btn").html('NOT');
    $("#add_btn").attr('value', 'NOT');
    var filter_option = $('#filter_option').val();
    var filter_value = $('#filter_value').val();
    var txt = $("#query_box").val(); 
    var queryBox = '';
    if(filter_option!='' && filter_value!='')
    {  
      if(txt)
      {
        var queryBox = txt+' OR (['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox); 
      }
      else
      {
        var queryBox = '(['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox);
      }      
    }
  });

  $('#submit_form').click(function(e){
    e.preventDefault();
    var add_btn = $("#add_btn").val();
    //alert(add_btn);
    var filter_option = $('#filter_option').val();
    var filter_value = $('#filter_value').val();
    var txt = $("#query_box").val(); 
    var queryBox = '';
     if(add_btn=='ADD')
     {
        var queryBox = '(['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox);
     }
     if(add_btn=='AND')
     {
        var queryBox = txt+' AND (['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox); 
     }
     if(add_btn=='OR')
     {
        var queryBox = txt+' OR (['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox); 
     }
     if(add_btn=='NOT')
     {
        var queryBox = txt+' NOT (['+filter_option+']'+filter_value+')';
        $("#query_box").html(queryBox); 
     }
     if(queryBox!="")
     {
      //alert('submit');
      $('#form_search').unbind('submit').submit();
     }
  });


</script>

</body>

</html>