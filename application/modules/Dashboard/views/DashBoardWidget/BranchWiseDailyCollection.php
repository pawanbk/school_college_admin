<div class="card">
  <div class="card-header" style="background-color: #56328c;">
    <h3 style="color: white;"><i class="fa fa-money"></i>&nbsp;&nbsp;Branch Wise Daily Collection</h3>
  </div>
  <div class="card-body" style="min-height: 300px; max-height: 300px; overflow-x: hidden; padding: 0.4rem 0.4rem;">
    <table class="table table-striped" >
      <tbody>
        <?php $grandTotal = 0; if(! empty($finance)){
          foreach($finance as $row){ ?>
            <tr>
              <td><?=$row['branch_name']?></td>
              <td><?=$row['amount']?></td>
            </tr>
            <?php 
            $grandTotal += $row['amount'];
          }
        } 
        else{ ?>
          <tr>
            <td colspan="2" style="text-align: center;">No Records Found</td>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
  <div class="card-footer" style="background-color: #f0d677;color: #444;">
    <center>Total Collection :-&nbsp;Rs.&nbsp;<?=$grandTotal;?></center>
  </div>
</div>
<!-- end box -->
