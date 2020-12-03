<div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

                            <li class="text-muted menu-title">MENU</li>      

                            
                                <?php 
                                      $department = $this->session->userdata('department');
                                      $jabatan = $this->session->userdata('jabatan');

                                      $menu = array();
                                      /*
                                      $scr = "SELECT headername,formname,formtitle,glyph FROM secure_form_register a
                                              INNER JOIN secure_form_akses b ON a.id_form=b.id_form
                                              INNER JOIN master_formheader c ON a.formheader=c.id_form
                                              WHERE b.formdepartment='".$department."' AND b.formjabatan='".$jabatan."'
                                              AND a.formstatus = 1 AND b.formstatus = 1 AND c.formstatus = 1
                                              ORDER BY c.ordinal";    
                                      */
                                      $scr = "SELECT headername,formname,formtitle,glyph FROM secure_form_register a
                                              INNER JOIN master_formheader c ON a.formheader=c.id_form
                                              AND a.formstatus = 1
                                              AND c.formstatus = 1
                                              ORDER BY c.ordinal";
                                              
                                      $query = $this->db->query($scr);
                                      foreach ($query->result() as $row)
                                      {
                                              $menu[] =  array('formheader' => $row->headername, 
                                                               'formname' => $row->formname, 
                                                               'formtitle' => $row->formtitle, 
                                                               'glyph' => $row->glyph
                                                              );
                                      }


                                      $scrgenerator = "";
                                      $headertemp = "";
                                      $headerclose = false;
                                      foreach ($menu as $variant) { 
                                      $header = $variant['formheader'];
                                      $formname = $variant['formname']; 
                                      $formtitle = $variant['formtitle'];
                                      $glyph = $variant['glyph'];

                                          if($header<>$headertemp){
                                             if($headertemp <> ""){
                                                 $scrgenerator .= '</ul>
                                                                   </li>';                                                 
                                             }     
                                 
                                             $scrgenerator .=  '
                                               <li class="has_sub">
                                               <a href="javascript:void(0);" class="waves-effect"><i class="'.$glyph.'"></i> <span> '.$header.' </span> 
                                               <span class="menu-arrow"></span></a>
                                               <ul class="list-unstyled">';

                                          }

                                       $headertemp = $header;
                                       $scrgenerator .= '<li><a href="'.$formname.'">'.$formtitle.'</a></li>'; 
                                       }

                                       echo $scrgenerator;
                                ?>        
                                      
                            



                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>