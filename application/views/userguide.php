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


    <section class="section dashboard">
          <div class="col-12">
           <div class="card">
              <div class="card-body">
                <h5 class="card-title">User Guide</h5>
                <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
              </div>
            </div>

          </div>
    </section>

  </main><!-- End #main -->

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
  </body>

</html>