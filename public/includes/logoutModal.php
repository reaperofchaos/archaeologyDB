
<!-- Modal -->
<div id="logout" class="modal fade bd-example-modal-xl" tabindex='-1' role="dialog">
  <div class="modal-dialog modal-dialog-centered-modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Logout</h4>
      </div>
      <div class="modal-body">
        <form id='logoutForm' action='logout.php' method='post'>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <input type='submit' name='submit' id='logoutSubmit' value='logout' /> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
