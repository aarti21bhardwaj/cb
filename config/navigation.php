<?php
    use Cake\Core\Configure;
    return [ 'Menu' =>
                 [
                  'Manage Profile' => [
                   'link' => [
                               'controller' => 'Users',
                               'action' => 'edit'
                             ],
                    'class' => 'fa fa-user',
                    'hide_from_roles' => ['tenant'],
                    'show_to_roles' => ['super_admin']
                   ],
                   'Manage Tenants' => [
                   'link' => [
                               'controller' => 'Tenants',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-male',
                    'hide_from_roles' => ['tenant'],
                    'show_to_roles' => ['super_admin']
                   ],
                   'Dashboard' => [
                   'link' => [
                               'controller' => 'Tenants',
                               'action' => 'dashboard'
                             ],
                    'class' => 'fa fa-home',
                    'hide_from_roles' => ['super_admin'],
                    'show_to_roles' => ['tenant']
                   ],
                   'Users' => [
                   'link' => [
                               'controller' => 'TenantUsers',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-group',
                    'hide_from_roles' => [''],
                    'show_to_roles' => ['tenant','super_admin']
                   ],
                   'Manage Super Admin Users' => [
                   'link' => [
                               'controller' => 'Users',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-unlock-alt',
                    'hide_from_roles' => ['tenant'],
                    'show_to_roles' => ['super_admin']
                   ],

                   'Client Dashboard' => [
                   'link' => [
                               'controller' => 'CorporateClientUsers',
                               'action' => 'dashboard'
                             ],
                    'class' => 'fa fa-home',
                    'hide_from_roles' => ['super_admin','tenant','instructor'],
                    'show_to_roles' => ['corporate_client']
                   ],
                   'Home' => [
                   'link' => [
                               'controller' => 'Instructors',
                               'action' => 'dashboard'
                             ],
                    'class' => 'fa fa-home',
                    'hide_from_roles' => ['super_admin','tenant'],
                    'show_to_roles' => ['instructor']
                   ],

                   'Course Management' => [
                       'link' => '#',
                       'class' => 'fa fa-book',
                       'hide_from_roles' => ['super_admin'],
                       'show_to_roles' => ['tenant','corporate_client','instructor'],
                       'children' => [
                              
                               'Schedule New Course' => [
                                'link' => [
                                   'controller' => 'Courses',
                                   'action' => 'add'
                                   ]
                                 ],
                               
                               'List Future Courses' => [
                                   'link' => ['controller' => 'Courses', 'action' => 'index?request=future_courses'],
                                      'hide_from_roles' => ['super_admin'],
                                      'show_to_roles' => ['tenant','corporate_client','instructor']
                                     ],
                                'List Past Courses' => [
                                   'link' => ['controller' => 'Courses', 'action' => 'index?request=past_courses'],
                                      'hide_from_roles' => ['super_admin'],
                                      'show_to_roles' => ['tenant','corporate_client','instructor']
                                     ],
                                
                                  'List Draft Courses' => [
                               'link' => ['controller' => 'Courses', 'action' => 'index?request=draft'],
                                  'hide_from_roles' => ['super_admin'],
                                  'show_to_roles' => ['tenant','corporate_client','instructor']
                                 ],
                               //  'Re-open Closed Course' => [
                               // 'link' => '#',
                               //    'hide_from_roles' => ['super_admin','instructor'],
                               //    'show_to_roles' => ['tenant','corporate_client']
                               //   ]
                                 'Re-Open Courses' => [
                               'link' => ['controller' => 'Courses', 'action' => 'reopen_course'],
                                  'hide_from_roles' => ['super_admin','instructor'],
                                  'show_to_roles' => ['tenant']
                                 ],
                             ],
                             
                             ],
                  'Instructors' => [
                   'link' => [
                               'controller' => 'Instructors',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-male',
                    'hide_from_roles' => ['super_admin','instructor'],
                    'show_to_roles' => ['tenant']
                   ],

                   'Students' => [
                   'link' =>  [
                                'controller' => 'Students',
                                'action' => 'index'
                              
                              ],
                    'class' => 'fa fa-graduation-cap',
                    'hide_from_roles' => ['super_admin'],
                    'show_to_roles' => ['tenant']
                   ],

                   'Employees(Students)' => [
                   'link' =>  [
                                'controller' => 'Students',
                                'action' => 'index'
                              
                              ],
                    'class' => 'fa fa-graduation-cap',
                    'hide_from_roles' => ['super_admin','tenant','instructor'],
                    'show_to_roles' => ['corporate_client']
                   ],

                   'Training Sites' => [
                   'link' => [
                               'controller' => 'TrainingSites',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-building',
                    'hide_from_roles' => ['super_admin'],
                    'show_to_roles' => ['tenant']
                   ],

                   'Corporate Clients' => [
                       'link' => '#',
                       'class' => 'fa fa-briefcase',
                       'hide_from_roles' => ['super_admin','instructor','corporate_client'],
                       'show_to_roles' => ['tenant'],
                       'children' => [
                              
                               'Clients List' => [
                                   'link' => ['controller' => 'CorporateClients', 'action' => 'index'],
                                      'hide_from_roles' => ['super_admin'],
                                      'show_to_roles' => ['tenant']
                                     ],
                               'Add Clients' => [
                                'link' => [
                                   'controller' => 'CorporateClients',
                                   'action' => 'add'
                                 ],
                                  'hide_from_roles' => ['super_admin'],
                                  'show_to_roles' => ['tenant']
                               ],
                               'Subcontracted Clients' => [
                                'link' => [
                                   'controller' => 'SubcontractedClients',
                                   'action' => 'index'
                                 ],
                                  'hide_from_roles' => ['super_admin'],
                                  'show_to_roles' => ['tenant']
                               ],
                                'Corporate Users' => [
                                'link' => [
                                   'controller' => 'CorporateClientUsers',
                                   'action' => 'index'
                                 ],
                                  'hide_from_roles' => ['super_admin','instructor','corporate_client'],
                                  'show_to_roles' => ['tenant']
                               ],  
                             ],
                            ],
                  'Locations' => [
                   'link' => [
                               'controller' => 'Locations',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-location-arrow',
                    'hide_from_roles' => ['super_admin','instructor'],
                    'show_to_roles' => ['tenant','corporate_client']
                   ],
                   'AED Management' => [  
                   'link' => 'https://www.aedpmdemo.com/login',
                    'target'=>"_blank",
                    'class' => 'fa fa-shopping-cart ',
                    'hide_from_roles' => ['super_admin','instructor','corporate_client'],
                    'show_to_roles' => ['tenant']
                   ], 
                   'Admins' => [
                       'link' => '#',
                       'class' => 'fa fa-group',
                       'hide_from_roles' => ['super_admin','tenant','instructors'],
                       'show_to_roles' => ['corporate_client'],
                       'children' => [
                              
                               'Administrators' => [
                                   'link' => ['controller' => 'CorporateClientUsers', 'action' => 'index'],
                                      'hide_from_roles' => ['super_admin','tenant','instructors'],
                                      'show_to_roles' => ['corporate_client']
                                     ],
                               'Add Administrator' => [
                                'link' => [
                                   'controller' => 'CorporateClientUsers',
                                   'action' => 'add'
                                 ],
                                  'hide_from_roles' => ['super_admin','tenant','instructors'],
                                  'show_to_roles' => ['corporate_client']
                               ]
                             ],
                             ],


                  
                   'Shop' => [  
                   'link' => 'https://www.trainingcenter911.com',
                    'target'=>"_blank",
                    'class' => 'fa fa-shopping-cart ',
                    'hide_from_roles' => ['super_admin','corporate_client'],
                    'show_to_roles' => ['instructor','tenant']
                   ], 
                   
                   'Key Management' => [
                       'link' => '#',
                       'class' => 'fa fa-key',
                       'hide_from_roles' => ['super_admin'],
                       'show_to_roles' => ['tenant'],
                       'children' => [
                              
                               'View Key Categories' => [
                                   'link' => ['controller' => 'KeyCategories', 'action' => 'index'],
                                      'hide_from_roles' => ['super_admin'],
                                      'show_to_roles' => ['tenant']
                                     ],
                                'Key Inventory' => [
                                   'link' => ['controller' => 'KeyInventories', 'action' => 'index'],
                                      'hide_from_roles' => ['super_admin'],
                                      'show_to_roles' => ['tenant']
                                     ],
                              
                             ],

                 
                             ],
                    'Course Settings' => [
                       'link' => '#',
                       'class' => 'fa fa-cog',
                       'hide_from_roles' => ['super_admin'],
                       'show_to_roles' => ['tenant'],
                       'children' => [
                              
                               'Course Types' => [
                                   'link' => ['controller' => 'CourseTypes', 'action' => 'index'],
                                      'hide_from_roles' => ['super_admin'],
                                      'show_to_roles' => ['tenant']
                                     ],
                               'Course Addons' => [
                                'link' => [
                                   'controller' => 'Addons',
                                   'action' => 'index'
                                 ],
                                  'hide_from_roles' => ['super_admin'],
                                  'show_to_roles' => ['tenant']
                               ],
                               'Course Type Categories' => [
                                'link' => [
                                   'controller' => 'CourseTypeCategories',
                                   'action' => 'index'
                                 ],
                                 ],
                               'Promo Codes' => [
                                'link' => [
                                   'controller' => 'PromoCodes',
                                   'action' => 'index'
                                 ],
                                 ]
                             ],

                             ],
                   'Index Settings' => [
                                      'link' => ['controller' => 'IndexSettings', 'action' => 'index'],
                                      'class' => 'fa fa-cog',
                                      'hide_from_roles' => ['super_admin'],
                                      'show_to_roles' => ['tenant'],
                                     ],

                   

                     
                   'Update Profile' => [
                   'link' => [
                               'controller' => 'Instructors',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-male',
                    'hide_from_roles' => ['super_admin','tenant'],
                    'show_to_roles' => ['instructor']
                   ],  
                   'Instructor' => [
                   'link' => [
                               'controller' => 'Instructors',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-user',
                    'hide_from_roles' => ['super_admin','tenant','instructor'],
                    'show_to_roles' => ['instructor']
                   ],  
                      


                             
                    'System Settings' => [
                       'link' => '#',
                       'class' => 'fa fa-cogs',
                       'hide_from_roles' => ['super_admin'],
                       'show_to_roles' => ['tenant'],
                       'children' => [
                              
                              'Config Settings' => [
                                   'link' => ['controller' => 'TenantConfigSettings', 'action' => 'add'],
                                      'hide_from_roles' => ['super_admin','instructor','corporate_client','student'],
                                      'show_to_roles' => ['tenant']
                                     ],
                              'Manage Theme' => [
                                   'link' => ['controller' => 'TenantThemes', 'action' => 'add'],
                                      'hide_from_roles' => ['super_admin','instructor','corporate_client','student'],
                                      'show_to_roles' => ['tenant']
                                     ],
                                     'Registration Settings' => [
                                   'link' => ['controller' => 'TenantConfigSettings', 'action' => 'registrationSettings'],
                                      'hide_from_roles' => ['super_admin','instructor','corporate_client','student'],
                                      'show_to_roles' => ['tenant']
                                     ],         
                               'Text Clips' => [
                                   'link' => ['controller' => 'TextClips', 'action' => 'index'],
                                      'hide_from_roles' => ['super_admin'],
                                      'show_to_roles' => ['tenant']
                                     ],
                                'Manage Profile' => [
                                   'link' => ['controller' => 'Tenants', 'action' => 'edit'],
                                      'hide_from_roles' => ['super_admin','instructor','corporate_client'],
                                      'show_to_roles' => ['tenant']
                                     ],
                                'Card Profiles' => [
                                   'link' => ['controller' => 'CardPrintingProfiles', 'action' => 'index'],
                                      'hide_from_roles' => ['super_admin','instructor','corporate_client'],
                                      'show_to_roles' => ['tenant']
                                     ],
                                'Email Settings' => [
                                   'link' => ['controller' => 'Emails', 'action' => 'index'],
                                      'hide_from_roles' => ['super_admin','instructor','corporate_client'],
                                      'show_to_roles' => ['tenant']
                                     ],
                                     
                             ]
                    ],
                    
              ],
          'Training Site Owner Menu' =>
                 [
                   'Course Management' => [
                       'link' => '#',
                       'class' => 'fa fa-book',
                       'hide_from_roles' => ['super_admin','instructor'],
                       'show_to_roles' => ['tenant','corporate_client'],
                       'children' => [
                              
                               'Schedule New Course' => [
                                'link' => [
                                   'controller' => 'Courses',
                                   'action' => 'add'
                                   ]
                                 ],
                               
                               'List Future Courses' => [
                                   'link' => ['controller' => 'Courses', 'action' => 'index?request=future_courses'],
                                      'hide_from_roles' => ['super_admin','instructor'],
                                      'show_to_roles' => ['tenant','corporate_client']
                                     ],
                                'List Past Courses' => [
                                   'link' => ['controller' => 'Courses', 'action' => 'index?request=past_courses'],
                                      'hide_from_roles' => ['super_admin','instructor'],
                                      'show_to_roles' => ['tenant','corporate_client']
                                     ],
                                
                                  'List Draft Courses' => [
                                   'link' => ['controller' => 'Courses', 'action' => 'index?request=draft'],
                                      'hide_from_roles' => ['super_admin','instructor'],
                                      'show_to_roles' => ['tenant','corporate_client']
                                  ],
                             ],
                             
                             ],
                  'Instructors' => [
                   'link' => [
                               'controller' => 'Instructors',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-male',
                    'hide_from_roles' => ['super_admin','instructoryyyy'],
                    'show_to_roles' => ['tenant']
                   ],

                   'Students' => [
                   'link' =>  [
                                'controller' => 'Students',
                                'action' => 'index'
                              
                              ],
                    'class' => 'fa fa-graduation-cap',
                    'hide_from_roles' => ['super_admin'],
                    'show_to_roles' => ['tenant']
                   ],

                   'Corporate Clients' => [
                       'link' => '#',
                       'class' => 'fa fa-briefcase',
                       'hide_from_roles' => ['super_admin','instructor','corporate_client'],
                       'show_to_roles' => ['tenant'],
                       'children' => [
                              
                               'Clients List' => [
                                   'link' => ['controller' => 'CorporateClients', 'action' => 'index'],
                                      'hide_from_roles' => ['super_admin'],
                                      'show_to_roles' => ['tenant']
                                     ],
                               'Add Clients' => [
                                'link' => [
                                   'controller' => 'CorporateClients',
                                   'action' => 'add'
                                 ],
                                  'hide_from_roles' => ['super_admin'],
                                  'show_to_roles' => ['tenant']
                               ],
                               'Subcontracted Clients' => [
                                'link' => [
                                   'controller' => 'SubcontractedClients',
                                   'action' => 'index'
                                 ],
                                  'hide_from_roles' => ['super_admin'],
                                  'show_to_roles' => ['tenant']
                               ],
                                'Corporate Users' => [
                                'link' => [
                                   'controller' => 'CorporateClientUsers',
                                   'action' => 'index'
                                 ],
                                  'hide_from_roles' => ['super_admin','instructor','corporate_client'],
                                  'show_to_roles' => ['tenant']
                               ],  
                             ],
                            ],
                  'Locations' => [
                   'link' => [
                               'controller' => 'Locations',
                               'action' => 'index'
                             ],
                    'class' => 'fa fa-location-arrow',
                    'hide_from_roles' => ['super_admin','instructor'],
                    'show_to_roles' => ['tenant','corporate_client']
                   ],
                   'AED Management' => [  
                   'link' => 'https://www.aedpmdemo.com/login',
                    'target'=>"_blank",
                    'class' => 'fa fa-shopping-cart ',
                    'hide_from_roles' => ['super_admin','instructor','corporate_client'],
                    'show_to_roles' => ['tenant']
                   ],
              ],
          ]
?>

  
  
  
