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
th
{
  color:#008080;
}
.deletesingle
{
  border: none;
    background: none;
    padding: 0px;
    margin: 0px;
}
.getRow
{
  border: none;
  background: none;
  padding: 0px;
  margin: 0px; 
}
</style>
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/plug-ins/1.13.1/features/searchHighlight/dataTables.searchHighlight.css">
  <!-- End Sidebar-->

  <main id="main" class="main" style="margin-left:0px;">
    
    <!-- <div class="alert alert-danger" role="alert">
      Please provide feedback for PUMA Database <a href="https://forms.office.com/pages/responsepage.aspx?id=48TPkEN-PUyFfmbfrxno_f888Njnt-VLq4hZRTyZKm1UNzJOVzZYWklUV0VWSFZQS1ExNjlFM1k5Ry4u" target="_blank" class="alert-link">Click Here</a>. Give it a click if you like.
    </div> -->
    <section class="section">
      <div class="row">
         <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Search Item</h5>

              <form class="row g-3" method="post" action="" id="form_search">
                <div class="row">
                  <div class="col-md-10">
                    <input class="form-control" id="search_query" value="<?php echo $search_query; ?>" placeholder="[coulmn_heading] value_needs to be search, Ex. [language]English" name="search_query">
                  </div>
                  <div class="col-md-1">
                    <button type="submit" id="submit" value="submit" class="btn btn-primary" >Submit</button>
                  </div>

                  <div class="col-md-1">
                    <a href="<?php echo site_url('dashboard/clearQuery') ?>"  >Clear Search</a>
                  </div>
                </div>
              </form>
              <br>
              <?php if(count($sql_temp)>0) { ?>
              <div class="col-md-11">
              <ul class="list-group">
                <?php $i =0; 
                foreach ($sql_temp as $key) { $i++;
                ?>
                <li class="list-group-item"><button class="deletesingle" value="<?php echo $key->sql_uid; ?>"><i class="bi bi-trash" style="margin-right:15px;" ></i></button><?php //echo $key->date_time; ?>#<?php echo $i; ?>
                  
                  <input class="form-check-input me-1" name="sql_ids" type="checkbox" value="<?php echo $key->sql_uid; ?>" id="<?php echo $i; ?>">
                  <span class="col-md-8"><?php echo $key->query; ?></span>
                  <span class="float-right" style="float:right;">
                    <form action="" method="post">
                      <input type="hidden" name="getSingleRecord" value="<?php echo $key->sql_uid; ?>">
                      <button type="submit" class="getRow" value="<?php echo $key->sql_uid; ?>" style="color:blue;"><?php echo $key->total_result; ?></button>
                    </form>
                  </span>
                  
                </li>
                <br>
              <?php } ?>
              </ul>
            </div>
             <div class="row">
              <div class="col-md-2"><button id="delete_multiple" class="btn btn-primary">Delete Mutiple</button></div>
              <div class="col-md-1"><button id="multiple_and" class="btn btn-primary">AND</button></div>
              <div class="col-md-1"><button id="multiple_or" class="btn btn-primary">OR</button></div>
             </div> 
            <?php } ?>
            </div>

        </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Results</h5>

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
                    <td scope="row"><?php echo $i; ?></td>
                   
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
  var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();
var output = d.getFullYear() + '_' +
    ((''+month).length<2 ? '0' : '') + month + '_' +
    ((''+day).length<2 ? '0' : '') + day;
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
                 title: 'PUMA_search_filter_'+output,
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      'Export CSV',
                 title: 'PUMA_search_filter_'+output,
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
</script>
<script>


  $(document).ready(function(){

  $("#submit").click(function(event){
    //event.preventDefault()
    var search_query = $("#search_query").val();
    $.ajax({
       url: "<?php echo site_url('dashboard/searchItemResult')?>",
       type:'post',
       data:{search_query:search_query},
       success:function(response){
        //alert(response);
          location.reload(); // reloading page
       }
    });
 
  });
});

 $('.deletesingle').click(function(){
    var sql_uid = $(this).val();
    var confirmation = confirm("are you sure you want to remove the search item?");
    if (confirmation) {
      $.ajax({
         url: "<?php echo site_url('dashboard/DeleteSingleSearch')?>",
         type:'post',
         data:{sql_uid:sql_uid},
         success:function(response){
            location.reload(); // reloading page
         }
      });
    }  
  });

//for delete jquery
$('#delete_multiple').click(function(){
  var checkboxValues = [];
  var checkboxValuesID = [];
  $('input[name=sql_ids]:checked').map(function() {
              checkboxValues.push($(this).val());
              checkboxValuesID.push($(this).attr("id"));
  });
  if(checkboxValues)
  {
    var confirmation = confirm("are you sure you want to remove the search item?");
    if (confirmation) {
      // execute ajax
      $.ajax({
       url: "<?php echo site_url('dashboard/deleteSearchItem')?>",
       type:'post',
       data:{checkboxValues:checkboxValues,checkboxValuesID:checkboxValuesID},
       success:function(response){
        //alert(response);
          location.reload(); // reloading page
       }
      });
        
    }
  }
});


// jquery for AND multiple
$('#multiple_and').click(function(){
  var checkboxValues = [];
  var checkboxValuesID = [];
  $('input[name=sql_ids]:checked').map(function() {
              checkboxValues.push($(this).val());
              checkboxValuesID.push($(this).attr("id"));
  });
  // alert(checkboxValues);
  // alert(checkboxValuesID);
  if(checkboxValues)
  {
    $.ajax({
     url: "<?php echo site_url('dashboard/AndSearchItem')?>",
     type:'post',
     data:{checkboxValues:checkboxValues,checkboxValuesID:checkboxValuesID},
     success:function(response){
        //alert(response);
        location.reload(); // reloading page
     }
    });
  }
});

//jquery for OR 
$('#multiple_or').click(function(){
  var checkboxValues = [];
  var checkboxValuesID = [];
  $('input[name=sql_ids]:checked').map(function() {
              checkboxValues.push($(this).val());
              checkboxValuesID.push($(this).attr("id"));
  });
  if(checkboxValues)
  {
    $.ajax({
     url: "<?php echo site_url('dashboard/OrSearchItem')?>",
     type:'post',
     data:{checkboxValues:checkboxValues,checkboxValuesID:checkboxValuesID},
     success:function(response){
        //alert(response);
        location.reload(); // reloading page
     }
    });
  }
});
</script>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>

</html>