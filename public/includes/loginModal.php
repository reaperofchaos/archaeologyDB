
<!-- Modal -->
<div id="login" class="modal fade bd-example-modal-xl" tabindex='-1' role="dialog">
  <div class="modal-dialog modal-dialog-centered-modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
        <form id='loginForm' action='login.php' method='post'>
            <table class='table'>
                <tr>
                    <td>
                        Username:
                    </td>
                    <td>
                        <input type='text' name='username' size='20' maxlength='80' /> 
                    </td>
                </tr>
                <tr>
                    <td>
                        Password:
                    </td>
                    <td>
                        <input type='password' name='pass' size='20' maxlength='20' /> 
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input type='submit' name='submit' id='loginSubmit' value='login' /> 
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input type='hidden' name='submitted' value='TRUE' />
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id='loginResults' ></span> 
                    </td>
                    <td>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#register'>Register</button>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
