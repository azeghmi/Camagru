<?php
$results = check_mail_activate($_SESSION['username']);
$mail_activate = $results['new_comment'] == 1 ? 1 : false;
if (!isset($_SESSION['username'])) {
    $error = array();
    if (isset($_SESSION['username_error'])) {
        $error[0] = "<p class=\"help is-danger\">Wrong username or password</p>";
        unset($_SESSION['username_error']);
    }
    if (isset($_SESSION['username_used'])) {
        $error[1] = "<p class=\"help is-danger\">Username is already used</p>";
        unset($_SESSION['username_used']);
    }
    if (isset($_SESSION['password_not_strong']))
        $error[2] = "<p class=\"help is-danger\">Password not strong</p>";

    if (isset($_SESSION['password_not_same']))
        $error[3] = "<p class=\"help is-danger\">Passwords are not identicals</p>";

    if (isset($_SESSION['mail_error']))
        $error[4] = "<p class=\"help is-danger\">Not a valid mail.</p>";

    if (isset($_SESSION['mail_reboot']))
        $error[5] = "<p class=\"help is-danger\">mail is send to reset your password.</p>";
}
if (isset($_GET['login']))
echo"
<div  class=\"section animate\">
       <div class=\"login\">
          <form action=\"./index.php?connect\" class=\"\" method=\"POST\">
            <div class=\"field\">
                  <label class=\"label\">Username</label>
                  <div class=\"control has-icons-left has-icons-right\">
                      <input class=\"input is-rounded\" type=\"text\" name=\"username\" placeholder=\"Butet\" required>
                        <span class=\"icon is-small is-left\">
                            <i class=\"fas fa-user\"></i>
                        </span>
                   </div>
            </div>
            <div class=\"field\">
                <label for=\"\" class=\"label\">Password</label>
                <div class=\"control has-icons-left has-icons-right\">
                    <input type=\"password\" name=\"pwd\" placeholder=\"*******\" class=\"input is-rounded\" required>
                     <span class=\"icon is-small is-left\">
                          <i class=\"fas fa-lock\"></i>
                    </span>
                </div>
            </div>
             $error[0]
            <a href=\"/index.php?forgot\">Forgot your password ?</a>
               <div class=\"field\">
                    <button class=\"button is-primary\" name=\"submit\">Login</button>
            </div>
            
          </form>
      </div>
    </div>
  </div>
</section>";
if (isset($_GET['signup']))
echo"
<div  class=\"section animate\">
        <div class=\"login\">
          <form action=\"./index.php?create\" class=\"\" method=\"POST\">
            <div class=\"field\">
             $error[1]  
              <label class=\"label\">Username</label>
                  <div class=\"control has-icons-left has-icons-right\">
                  <input class=\"input  is-rounded\" type=\"text\" name=\"username\" placeholder=\"Butet\" required>
                   <span class=\"icon is-small is-left\">
                        <i class=\"fas fa-user\"></i>
                    </span>
                </div>
            </div>
            <div class=\"field\">
            $error[4]
              <label class=\"label\">Email</label>
               <div class=\"control has-icons-left has-icons-right\">
                  <input class=\"input  is-rounded\" type=\"email\" name=\"mail_1\" placeholder=\"Butetgrko@gmail.com\"required>
                  <span class=\"icon is-small is-left\">
                      <i class=\"fas fa-envelope\"></i>
                    </span>
                </div>
            </div>
            <div class=\"field\">
              <label class=\"label\">Email</label>
                <div class=\"control has-icons-left has-icons-right\">
                  <input class=\"input  is-rounded\" type=\"email\" name=\"mail_2\" placeholder=\"Butetgrko@gmail.com\"required>
                  <span class=\"icon is-small is-left\">
                      <i class=\"fas fa-envelope\"></i>
                    </span>
                </div>
            </div>     
            <div class=\"field\">
              $error[2]  
              $error[3]
              <label for=\"\" class=\"label\">Password</label>
              <div class=\"control has-icons-left has-icons-right\">
                <input type=\"password\" placeholder=\"*******\"name=\"pwd_1\" class=\"input  is-rounded\"required>
                 <span class=\"icon is-small is-left\">
                          <i class=\"fas fa-lock\"></i>
                    </span>
              </div>
            </div>
            <div class=\"field\">
              <label for=\"\" class=\"label\">Password</label>
              <div class=\"control has-icons-left has-icons-right\">
                <input type=\"password\" placeholder=\"*******\" name=\"pwd_2\" class=\"input  is-rounded\"required>
                 <span class=\"icon is-small is-left\">
                          <i class=\"fas fa-lock\"></i>
                    </span>
              </div>
            </div>            
            <div class=\"field is-grouped\">
              <div class=\"control\">
                <button class=\"button is-primary\" name=\"submit\" >Creat</button>
              </div>
          </form>
      </div>
      </div>
    </div>
  </div>
</section>";

if (isset($_GET['forgot']))
{
    echo"
<div  class=\"section animate\">
       <div class=\"login\">
          <form action=\"./index.php?mail_password\" class=\"\" method=\"POST\">
          <h1 id=\"special_title\" class=\"title\">Reset your password</h1>
             <div class=\"field\">
              <label class=\"label\">Name</label>
                <div class=\"control has-icons-left has-icons-right\">
                  <input class=\"input  is-rounded\" type=\"text\" name=\"username\" placeholder=\"Butet\" required>
                  <span class=\"icon is-small is-left\">
                      <i class=\"fas fa-user\"></i>
                    </span>
                </div>
            </div>
            <div class=\"field\">
                <label for=\"\" class=\"label\">Mail</label>
                <div class=\"control has-icons-left has-icons-right\">
                    <input class=\"input  is-rounded\" type=\"email\" name=\"mail\" placeholder=\"Butetgrko@gmail.com\"required>
                     <span class=\"icon is-small is-left\">
                          </i><i class=\"fas fa-envelope\"></i>
                    </span>
                </div>
            </div>          
            <div class=\"field is-grouped\">
              <div class=\"control\">
                <button class=\"button is-primary\" name=\"submit\" >Creat</button>
              </div>
          </form>
      </div>
    </div>
  </div>
</section>";
}

if (isset($_GET['profil']))
{
  if (isset($_POST['new_mail']))
  {
    echo"
<div  class=\"section animate\">
            <div class=\"login\">
            <form action=\"./index.php?profil\" class=\"\" method=\"POST\">
                <div class=\"field\">
                  <label class=\"label\">Name: $_SESSION[username]</label>
                </div>
                <div class=\"field\">
                  <label class=\"label\">Email: $_SESSION[mail]</label>     
                </div>
                <div class=\"field\">
                  <div class=\"control\">
                    <button class=\"button is-warning small\" name=\"new_user_name\" >Change username</button>
                    <br><br>
                    <button class=\"button is-warning small\" name=\"new_mail\" >Change mail</button>
                    <br><br>
                    <button class=\"button is-warning small\" name=\"new_user_password\" >Change password </button>
                  </div>
                </div>
              </form>
              <form action=\"./index.php?Submit_email\"  method=\"POST\">
              <div class=\"field\">
              <label class=\"label\">Old mail</label>
                <div class=\"control has-icons-left has-icons-right\">
                  <input class=\"input  is-rounded\" type=\"email\" name=\"old_mail\" placeholder=\"Butetgrko@gmail.com\"required>
                  <span class=\"icon is-small is-left\">
                      <i class=\"fas fa-envelope\"></i>
                    </span>
                </div>
            </div>
            <div class=\"field\">
              <label class=\"label\">new mail</label>
                <div class=\"control has-icons-left has-icons-right\">
                  <input class=\"input  is-rounded\" type=\"email\" name=\"new_mail\" placeholder=\"Butetgrko@gmail.com\"required>
                  <span class=\"icon is-small is-left\">
                      <i class=\"fas fa-envelope\"></i>
                    </span>
                </div>
            </div>
            <div class=\"field\">
              <label class=\"label\">Confirm new mail</label>
                <div class=\"control has-icons-left has-icons-right\">
                  <input class=\"input  is-rounded\" type=\"email\" name=\"conf_new_mail\" placeholder=\"Butetgrko@gmail.com\"required>
                  <span class=\"icon is-small is-left\">
                      <i class=\"fas fa-envelope\"></i>
                    </span>
                </div>
            </div>
                    <br>
                    <button class=\"button is-warning small\" name=\"submit\" >Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>";
  }
  else if (isset($_POST['new_user_password']))
  {
    echo"
<div  class=\"section animate\">
            <div class=\"login\">
                <form action=\"./index.php?profil\" class=\"\" method=\"POST\">
                <div class=\"field\">
                  <label class=\"label\">Name: $_SESSION[username]</label>
                </div>
                <div class=\"field\">
                  <label class=\"label\">Email: $_SESSION[mail]</label>     
                </div>
                <div class=\"field\">
                  <div class=\"control\">
                    <button class=\"button is-warning small\" name=\"new_user_name\" >Change username</button>
                    <br><br>
                    <button class=\"button is-warning small\" name=\"new_mail\" >Change mail</button>
                    <br><br>
                    <button class=\"button is-warning small\" name=\"new_user_password\" >Change password </button>
                  </div>
                </div>
              </form>
                  <form action=\"./index.php?change_password\"  method=\"POST\">
                   
                  <div class=\"field\">
                      <label for=\"\" class=\"label\">Old password</label>
                             <div class=\"control has-icons-left has-icons-right\">
                          <input type=\"password\" placeholder=\"*******\"name=\"pwd_old\" class=\"input  is-rounded\"required>
                          <span class=\"icon is-small is-left\">
                          <i class=\"fas fa-lock\"></i>
                    </span>
                        </div>
                    </div>
                        <div class=\"field\">
                          <label for=\"\" class=\"label\">New password</label>
                            <div class=\"control has-icons-left has-icons-right\">
                              <input type=\"password\" placeholder=\"*******\"name=\"new_pwd_1\" class=\"input  is-rounded\"required>
                              <span class=\"icon is-small is-left\">
                                 <i class=\"fas fa-lock\"></i>
                            </span>
                            </div>
                          </div>
    
                        <div class=\"field\">
                          <label for=\"\" class=\"label\">Confirm new password</label>
                             <div class=\"control has-icons-left has-icons-right\">
                              <input type=\"password\" placeholder=\"*******\" name=\"new_pwd_2\" class=\"input  is-rounded\"required>
                              <span class=\"icon is-small is-left\">
                                   <i class=\"fas fa-lock\"></i>
                             </span>
                            </div>
                        </div>
                        <br>
                        <button class=\"button is-warning small\" name=\"submit\" >Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>";
  }
  else if (isset($_POST['new_user_name']))
  {
    echo"
<div  class=\"section animate\">
            <div class=\"login\">
                <form action=\"./index.php?profil\" class=\"\" method=\"POST\">
                <div class=\"field\">
                  <label class=\"label\">Name: $_SESSION[username]</label>
                </div>
                <div class=\"field\">
                  <label class=\"label\">Email: $_SESSION[mail]</label>     
                </div>
                <div class=\"field\">
                  <div class=\"control\">
                    <button class=\"button is-warning small\" name=\"new_user_name\" >Change username</button>
                    <br><br>
                    <button class=\"button is-warning small\" name=\"new_mail\" >Change mail</button>
                    <br><br>
                    <button class=\"button is-warning small\" name=\"new_user_password\" >Change password </button>
                  </div>
                </div>
              </form>
              <form action=\"./index.php?change_username\"  method=\"POST\">
                <div class=\"field\">
                  <label for=\"\" class=\"label\">Username</label>
                    <div class=\"control has-icons-left has-icons-right\">
                      <input class=\"input  is-rounded\" type=\"text\" name=\"old_username\" placeholder=\"Butet\" required>
                          <span class=\"icon is-small is-left\">
                        <i class=\"fas fa-user\"></i>
                    </span>
                  </div>
                </div>

                <div class=\"field\">
                  <label for=\"\" class=\"label\">New username</label>
                    <div class=\"control has-icons-left has-icons-right\">
                      <input class=\"input  is-rounded\" type=\"text\" name=\"new_username\" placeholder=\"Butet\" required>
                          <span class=\"icon is-small is-left\">
                        <i class=\"fas fa-user\"></i>
                    </span>
                  </div>
                </div>

                <div class=\"field\">
                  <label for=\"\" class=\"label\">Confirm new username</label>
                    <div class=\"control has-icons-left has-icons-right\">
                      <input class=\"input  is-rounded\" type=\"text\" name=\"conf_new_username\" placeholder=\"Butet\" required>
                          <span class=\"icon is-small is-left\">
                        <i class=\"fas fa-user\"></i>
                    </span>
                  </div>
                </div>
                    <br>
                    <button class=\"button is-warning small\" name=\"submit\" >Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>";
  }
  else
    echo"
<div  class=\"section animate \">
            <div class=\"login column is-half\">   
              <form action=\"./index.php?profil\" class=\" \" method=\"POST\">
                <div class=\"field\">
                  <label class=\"label has-text-centered\">Name: $_SESSION[username]</label>
                </div>
                <div class=\"field has-text-centered\">
                  <label class=\"label\">Email: $_SESSION[mail]</label>
                </div>
            
                <div class=\"field has-text-centered\">
                  <div class=\"control has-text-centered\">
                    <button class=\"button is-warning small\" name=\"new_user_name\" >Change username</button>
                    <br><br>
                    <button class=\"button is-warning small\" name=\"new_mail\" >Change mail</button>
                    <br><br>
                    <button class=\"button is-warning small\" name=\"new_user_password\" >Change password </button>
                  </div>
                </div>
                 <label id=\"special_title\" class=\"label has-text-centered\">New comments notifications</label>
            <div class=\"field has-text-centered\">
                <label class=\"checkbox\">
                    <input id=\"mail_activate\" type=\"checkbox\"";
                    if ($mail_activate == 1)echo " checked";echo "
                    > Send notifications by mail
                </label>
            </div>
              </form>
            </div>
          </div>
 
    </section>";
}

else if (isset($_GET['login']) && isset($_GET['mail_password_confirmation']) && isset($_GET['username']) && isset($_GET['password_key']))
{
    $bdd_password_key = mail_password_confirmation($_GET['username'], $_GET['password_key']);
    $error = "";
    if (isset($_SESSION['change_password_success']) && $_SESSION['change_password_success'] == "not_same")
        $error = "<p class=\"help is-danger\">Passwords are not identicals.</p>";
    if ($_GET['password_key'] == $bdd_password_key)
    {
        $password_key = $_GET['password_key'];
        $username = $_GET['username'];
        echo "  <div id=\"login-section\" class=\"section animate\">
                <div class=\"container\">
                    <div class=\"login\">
                        <form action=\"/controller/controller.php?change_password_by_forgot&username=$username&password_key=$password_key\" method=\"POST\">
                            <h1 id=\"special_title\" class=\"title\">Reset your password</h1>
                            <div class=\"field\">
                                <p class=\"control has-icons-left has-icons-right\">
                                    <input class=\"input is-medium\" name=\"password\" type=\"password\" placeholder=\"New Password\" required>
                                    <span class=\"icon is-medium is-left\">
                                        <i class=\"fas fa-lock\"></i>
                                    </span>
                                </p>
                            </div>
                            <div class=\"field\">
                                <p class=\"control has-icons-left has-icons-right\">
                                    <input class=\"input is-medium\" name=\"password_confirm\" type=\"password\" placeholder=\"Confirm New Password\" required>
                                        <span class=\"icon is-medium is-left\">
                                            <i class=\"fas fa-lock\"></i>
                                        </span>
                                </p>
                                $error
                            </div>
                            <input id=\"login_button\" style=\"width: 100%\" type=\"submit\" name=\"submit\" value=\"Change password\" class=\"button is-small is-success\">
                        </form>
                    </div>
                </div>
            </div>";
    }
}
?>

<script>
    if (window.location.href === 'https://camagru.planethoster.world/index.php?profil'){
        let mail_activate = document.querySelector('#mail_activate');
        mail_activate.addEventListener('change', function(){
            let checked = this.checked;
            checked = checked == false ? 0 : 1;
            var hr = new XMLHttpRequest();
            var url = "/controller/controller.php?notifComments";
            var vars = "checked=" + checked;

            hr.open("POST", url, true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.setRequestHeader('cache-control', 'no-cache, must-revalidate, post-check=0, pre-check=0');
            hr.send(vars);
        });
    }
</script>


