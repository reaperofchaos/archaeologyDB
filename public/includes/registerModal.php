
<!-- Modal -->
<div id="register" class="modal fade bd-example-modal-xl" tabindex='-2' role="dialog">
<div class="modal-dialog modal-dialog-centered-modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create An Account</h4>
      </div>
      <div class="modal-body">
        <form id='registerForm' action='register.php' method='post'>
        <table class='table'>
                <tbody>
                    <tr>
                        <td>
                            Username:
                        </td>
                        <td>
                            <input type="text" name="username" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Name:
                        </td>
                        <td>
                            <input type="text" name="name" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email:
                        </td>
                        <td>
                            <input type="email" name="email" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Password:
                        </td>
                        <td>
                            <input type="password" name="password_1" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Confirm Password</label>
                        </td>
                        <td>
                            <input type="password" name="password_2" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <button type="submit" class="btn" id='registerSubmit' name="reg_user">Register</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
