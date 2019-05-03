<?php
use Cake\Core\Configure;
  return [ 
          'events' => [
                        ['name' => 'Course Registration Confirmation','event_key' => 'course_registration_confirmation','is_schedulable' => '0',
                         'event_variables' => [
                                                array('name' => 'Student Name','description' => 'Student Name','variable_key' => 'name'),
                                                array('name' => 'Course ID','description' => 'Course ID','variable_key' => 'course_id'),
                                                array('name' => 'Course Type Agency','description' => 'Course Type Agency','variable_key' => 'course_type_agency'),
                                                array('name' => 'Course Type','description' => 'Course Type','variable_key' => 'course_type'),
                                                array('name' => 'Course Date','description' => 'Course Date','variable_key' => 'course_date'),
                                                array('name' => 'Start time','description' => 'Course Start Time ','variable_key' => 'course_start_time'),
                                                array('name' => 'End Time','description' => 'Course End Time ','variable_key' => 'course_end_time'),
                                                array('name' => 'Location Name','description' => 'Course Location Name','variable_key' => 'location_name'),
                                                array('name' => 'Location Address','description' => 'Course Location Address','variable_key' => 'location_address'),
                                                array('name' => 'Location City','description' => 'Course Location City','variable_key' => 'location_city'),
                                                array('name' => 'Location State','description' => 'Course Location State','variable_key' => 'location_state'),
                                                array('name' => 'Location Zipcode','description' => 'Course Location Zipcode','variable_key' => 'location_zipcode'),
                                                array('name' => 'Server Name','description' => 'Server Name','variable_key' => 'server_name'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Student Name','description' => 'Student Name','variable_key' => 'user_name'),
                                                array('name' => 'Student Password','description' => 'Student Password','variable_key' => 'user_password'),
                                            ],
                          'emails' => [
                                        array('subject' => 'Your Course Registration Details From {{training_site_name}}','from_name' => '','from_email' => '','body' => '<p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Hi {{first_name}}- Thank you for registering for a course offered by {{training_site_name}}.</span></p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">&nbsp;</p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Your registration details are shown below. </span></p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Course ID: {{course_id}}</span></p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">&nbsp;</p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Course Type: {{course_type_agency}} {{course_type}}</span></p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">&nbsp;</p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Course Date/Time: {{course_date}} | {{course_start_time}} - {{course_end_time}}.</span></p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">&nbsp;</p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Course Location: {{location_name}} Course Address: {{location_address}},{{location_city}}, {{location_state}} {{location_zipcode}}.</span></p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">&nbsp;</p>
                                          <p style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Your Login Details: Login Url: http://{{server_name}}/students/login Student Email: {{user_email}}. Important Reminders: Plan to arrive at least 10 minutes early. Student who arrive late will not be admitted into the course. Dress comfortably as you will be practicing CPR skills on the classroom floor. Infants, young children and interpreters are not allowed to attend the course with any student. Your certification card will be emailed to you within 3 business days after the class.</span></p>','status' => '1','use_system_email' => '1')
                                      ]                  
                        ],
                        ['name' => 'Course Payment Confirmation','event_key' => 'course_payment_confirmation','is_schedulable' => '0',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Course Payment Date','description' => 'Course Payment Date','variable_key' => 'course_payment_date'),
                                                array('name' => 'Course Payment Method','description' => 'Course Payment Method ','variable_key' => 'course_payment_method'),
                                                array('name' => 'Course Amount','description' => 'Course Amount','variable_key' => 'course_amount'),
                                                array('name' => 'Course Id','description' => 'Course Id','variable_key' => 'course_id'),
                                                array('name' => 'Course Type Agency','description' => 'Course Type Agency','variable_key' => 'course_type_agency'),
                                                array('name' => 'Course Type','description' => 'Course Type','variable_key' => 'course_type'),
                                                array('name' => 'Course Date','description' => 'Course Date','variable_key' => 'course_date'),
                                                array('name' => 'Course Start Time','description' => 'Course Start Time','variable_key' => 'course_start_time'),
                                                array('name' => 'Course End Date','description' => 'Course End Date','variable_key' => 'course_end_time'),
                                                array('name' => 'Location Name','description' => 'Location Name','variable_key' => 'location_name'),
                                                array('name' => 'Location Address','description' => 'Location Address','variable_key' => 'location_address'),
                                                array('name' => 'Location City','description' => 'Location City','variable_key' => 'location_city'),
                                                array('name' => 'Location State','description' => 'Location State','variable_key' => 'location_state'),
                                                array('name' => 'Location Zipcode','description' => 'Location Zipcode','variable_key' => 'location_zipcode'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                            ],
                          'emails' => [
                                        array('subject' => 'Payment Confirmation From {{training_site_name}}','from_name' => '','from_email' => '','body' => '<p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Hi {{first_name}}- Thank you for your payment, </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Your credit card has been charged in the amount shown below: </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">PAYMENT RECEIPT </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Date of Payment: {{course_payment_date}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Payment Method: {{course_payment_method}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Payment Amount: $ {{course_amount}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course ID: {{course_id}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Type: {{course_type_agency}} {{course_type}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Date/Time: {{course_date}} | {{course_start_time}} - {{course_end_time}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Location: {{location_name}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Address: {{location_address}}, {{location_city}}, {{location_state}} {{location_zipcode}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}</span></p>','status' => '1','use_system_email' => '1'),
                                      ]                  
                        ],
                        ['name' => 'Account Password Update Instructor','event_key' => 'account_password_update_instructor','is_schedulable' => '0',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Last Name','description' => 'Last Name','variable_key' => 'last_name'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                array('name' => 'User Name','description' => 'User Name','variable_key' => 'user_name'),
                                                array('name' => 'User Password','description' => 'User Password','variable_key' => 'user_password'),
                                                array('name' => 'Server Name','description' => 'Server Name','variable_key' => 'server_name'),
                                            ],
                          'emails' => [
                                         array('subject' => 'Your {{training_site_name}} Instructor Account Password Updated','from_name' => '','from_email' => '','body' => '<p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Hi {{first_name}}- </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Your instructor account with {{training_site_name}} password has been successfully updated. Your login credentials to our instructor portal are shown below. </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Instructor Portal URL: <a href="https://{server_name}/b/instructor/">https://{{server_name}}/instructors/login </a></span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Username: {{user_name}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Password: {{user_password}} </span></p>
                                          <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">In the future when courses are available in your region you will receive an training opportunity email. To accept or decline the opportunity login to the instructor portal. If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}} </span></p>','status' => '1','use_system_email' => '1'),
                                      ]                  
                        ],
                        ['name' => 'Account Creation Notification Instructor','event_key' => 'account_creation_notification_instructor','is_schedulable' => '0',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Server Name','description' => 'Name of Server ','variable_key' => 'server_name'),
                                                array('name' => 'User Name','description' => 'User Name','variable_key' => 'user_name'),
                                                array('id' => '74','event_id' => '1','name' => 'User Password','description' => 'User Password','variable_key' => 'user_password'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                array('name' => 'User Password','description' => 'User Password','variable_key' => 'user_password'),
                                                array('name' => 'email validation url','description' => 'email validation url','variable_key' => 'confirm_url'),
                                                array('name' => 'Last Name','description' => 'Last Name','variable_key' => 'last_name'),
                                            ],
                          'emails' => [
                                         array('subject' => 'Your {{training_site_name}} Instructor Account','from_name' => '','from_email' => '','body' => '<p><span style="font-weight: 400;">Hi {{first_name}} {{last_name}}- </span></p>
                                          <p><span style="font-weight: 400;">Your instructor account with {{training_site_name}} has been successfully created. Your login credentials to our instructor portal are shown below. </span></p>
                                          <p> Email Validation Url : {{confirm_url}} </p>
                                          <p><span style="font-weight: 400;">Instructor Portal URL: {{server_name}} </span></p>
                                          <p><span style="font-weight: 400;">Username: {{user_name}} </span></p>
                                          <p><span style="font-weight: 400;">Password: {{user_password}} </span></p>
                                          <p><span style="font-weight: 400;">In the future when courses are available in your region you will receive an training opportunity email. To accept or decline the opportunity login to the instructor portal. If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}} </span></p>','status' => '1','use_system_email' => '1'),
                                      ]                  
                        ],
                        ['name' => 'Training Opportunity Notification -Instructor','event_key' => 'training_opportunity_notification_instructor','is_schedulable' => '0',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Last Name','description' => 'Last Name','variable_key' => 'last_name'),
                                                array('name' => 'Server Name','description' => 'Name of Server','variable_key' => 'server_name'),
                                                array('name' => 'Course Id','description' => 'Course Id','variable_key' => 'course_id'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Course Type Agency','description' => 'Course Type Agency','variable_key' => 'course_type_agency'),
                                                array('name' => 'Course Type','description' => 'Course Type','variable_key' => 'course_type'),
                                                array('name' => 'Course Date','description' => 'Course Date','variable_key' => 'course_date'),
                                                array('name' => 'Content','description' => 'Content','variable_key' => 'content'),
                                                array('name' => 'Course Start Time','description' => 'Course Start Time','variable_key' => 'course_start_time'),
                                                array('name' => 'Course End Time','description' => 'Course End Time','variable_key' => 'course_end_time'),
                                                array('name' => 'Location City','description' => 'Location City','variable_key' => 'location_city'),
                                                array('name' => 'Location State','description' => 'Location State','variable_key' => 'location_state'),
                                                array('name' => 'Location Zipcode','description' => 'Location Zipcode','variable_key' => 'location_zipcode'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                            ],
                          'emails' => [
                                         array('subject' => 'Available Training Opportunity From {{training_site_name}}','from_name' => '','from_email' => '','body' => '<p><span style="font-weight: 400;">Dear {{first_name}} {{last_name}}- </span></p>
                                          <p><span style="font-weight: 400;">{{content}} {{training_site_name}}. </span></p>
                                          <p><span style="font-weight: 400;">Course ID: {{course_id}} </span></p>
                                          <p><span style="font-weight: 400;">Course Type: {{course_type_agency}} {{course_type}} </span></p>
                                          <p><span style="font-weight: 400;">Course Date/Time: {{course_date}} | {{course_start_time}}:{{course_end_time}} </span></p>
                                          <p><span style="font-weight: 400;">Course Location: {{location_city}}, {{location_state}} {{location_zipcode}}. </span></p>
                                          <p>&nbsp;</p>
                                          <p><span style="font-weight: 400;">To accept or decline this course, please login to our instructor portal at {{server_name}} Please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}} if you have any questions about this assignment.</span></p>','status' => '1','use_system_email' => '1'),
                                      ]                  
                        ],
                        ['name' => 'Training Opportunity Reassignment Notification Instructor','event_key' => 'training_opportunity_reassignment_notification_Instructor','is_schedulable' => '0',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Last Name','description' => 'Last Name','variable_key' => 'last_name'),
                                                array('name' => 'Course Id','description' => 'Course Id','variable_key' => 'course_id'),
                                                array('name' => 'Course Type Agency','description' => 'Course Type Agency','variable_key' => 'course_type_agency'),
                                                array('name' => 'Course Type','description' => 'Course Type','variable_key' => 'course_type'),
                                                array('name' => 'Course Date','description' => 'Course Date','variable_key' => 'course_date'),
                                                array('name' => 'Course Start Time','description' => 'Course Start Time','variable_key' => 'course_start_time'),
                                                array('name' => 'Location City','description' => 'Location City','variable_key' => 'location_city'),
                                                array('name' => 'Location State','description' => 'Location State','variable_key' => 'location_state'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                            ],
                          'emails' => [
                                          array('subject' => 'Training Opportunity Reassigned By {{training_site_name}}','from_name' => '','from_email' => '','body' => '<p><span style="font-weight: 400;">Hi {{first_name}} {{last_name}}- </span></p>
                                            <p><span style="font-weight: 400;">A training opportunity that was previously offered to you has been reassigned to another instructor. </span></p>
                                            <p><span style="font-weight: 400;">The class details are shown below. </span></p>
                                            <p><span style="font-weight: 400;">Course ID: {{course_id}} </span></p>
                                            <p><span style="font-weight: 400;">Course Type: {{course_type_agency}} {{course_type}} </span></p>
                                            <p><span style="font-weight: 400;">Course Date/Time: {{course_date}} at {{course_start_time}} </span></p>
                                            <p><span style="font-weight: 400;">Course Location: {{location_city}} {{location_state}} </span></p>
                                            <p><span style="font-weight: 400;">If you have any questions about this assignment, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}</span></p>
                                            <span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;"><br /><br /></span>','status' => '1','use_system_email' => '1'),
                                      ]                  
                        ],
                        ['name' => 'Account Password Update Notification - Corporate','event_key' => 'account_password_update_notification_corporate','is_schedulable' => '0',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Last Name','description' => 'Last Name','variable_key' => 'last_name'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                array('name' => 'User Name','description' => 'User Name','variable_key' => 'user_name'),
                                                array('name' => 'User Password','description' => 'User Password','variable_key' => 'user_password'),
                                                array('name' => 'Server Name','description' => 'Name of Server','variable_key' => 'server_name'),
                                            ],
                          'emails' => [
                                           array('subject' => 'Your {{training_site_name}} Corporate user  Account Password Updated','from_name' => '','from_email' => '','body' => '<p><span style="font-weight: 400;">Hi {{first_name}} {{last_name}}- </span></p>
                                              <p><span style="font-weight: 400;">Your Corporate client account with {{training_site_name}} password has been successfully updated. Your login credentials to our Corporate Client portal are shown below. </span></p>
                                              <p><span style="font-weight: 400;">Tenant Portal URL: https://{{server_name}}/corporate-clients/login </span></p>
                                              <p><span style="font-weight: 400;">Username: {{user_name}} </span></p>
                                              <p><span style="font-weight: 400;">Password: {{user_password}} If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}} </span></p>','status' => '1','use_system_email' => '1'),
                                      ]
                        ],
                        ['name' => 'Instructor Certifications Expiring Notification - 90 Days','event_key' => 'instructor_certifications_expiring_in_90_days','is_schedulable' => '1',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Last Name','description' => 'Last Name','variable_key' => 'last_name'),
                                                array('name' => 'Course Type','description' => 'Course Type','variable_key' => 'course_type'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                array('name' => 'Instructor Expiry Date','description' => 'Instructor Expiry Date','variable_key' => 'instructor_expiry_date'),
                                            ],
                          'emails' => [
                                           array('subject' => 'Certifications Expiring in 90 Days','from_name' => '','from_email' => '','body' => '<p><span style="font-weight: 400;">Hi {{first_name}} {{last_name}}- </span></p>
                                            <p><span style="font-weight: 400;">According to our records you have the following certifications expiring in the next 90 days: </span></p>
                                            <p><span style="font-weight: 400;">Certification Type {{course_type_agency}} {{course_type}} </span></p>
                                            <p><span style="font-weight: 400;">Expiration Date {{instructor_expiry_date}} </span></p>
                                            <p><span style="font-weight: 400;">If you have already renewed any of theses certifications please send us a copy for our records. If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}. </span></p>','status' => '1','use_system_email' => '1'),
                                      ]
                        ],
                        ['name' => 'Instructor Certifications Expiring Notification - 60 Days','event_key' => 'instructor_certifications_expiring_notification_60_days','is_schedulable' => '1',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Last Name','description' => 'Last Name','variable_key' => 'last_name'),
                                                array('name' => 'Course Type Agency','description' => 'Course Type Agency','variable_key' => 'course_type_agency'),
                                                array('name' => 'Course Type','description' => 'Course Type','variable_key' => 'course_type'),
                                                array('name' => 'Instructor Expiry Date','description' => 'Instructor Expiry Date','variable_key' => 'instructor_expiry_date'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                            ],
                          'emails' => [
                                           array('subject' => 'Certifications Expiring in 60 Days','from_name' => '','from_email' => '','body' => '<p><span style="font-weight: 400;">Hi {{first_name}} {{last_name}}- </span></p>
                                            <p><span style="font-weight: 400;">According to our records you have the following certifications expiring in the next 60 days: </span></p>
                                            <p><span style="font-weight: 400;">Certification Type {{course_type_agency}} {{course_type}} </span></p>
                                            <p><span style="font-weight: 400;">Expiration Date {{instructor_expiry_date}} </span></p>
                                            <p><span style="font-weight: 400;">If you have already renewed any of theses certifications please send us a copy for our records. If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}. </span></p>','status' => '1','use_system_email' => '1'),
                                      ]
                        ],
                        ['name' => 'Instructor Certifications Expiring Notification - 30 Days','event_key' => 'instructor_certifications_expiring_notification_30_days','is_schedulable' => '1',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Last Name','description' => 'Last Name','variable_key' => 'last_name'),
                                                array('name' => 'Course Type','description' => 'Course Type','variable_key' => 'course_type'),
                                                array('name' => 'Course Type Agency','description' => 'Course Type Agency','variable_key' => 'course_type_agency'),
                                                array('name' => 'Instructor Expiry Date','description' => 'Instructor Expiry Date','variable_key' => 'instructor_expiry_date'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                            ],
                          'emails' => [
                                           array('subject' => 'Certifications Expiring in 30 Days','from_name' => '','from_email' => '','body' => '<p><span style="font-weight: 400;">Hi {{first_name}} {{last_name}}- </span></p>
                                            <p><span style="font-weight: 400;">According to our records you have the following certifications expiring in the next 30 days: </span></p>
                                            <p><span style="font-weight: 400;">Certification Type {{course_type_agency}} {{course_type}} </span></p>
                                            <p><span style="font-weight: 400;">Expiration Date {{instructor_expiry_date}} </span></p>
                                            <p><span style="font-weight: 400;">If you have already renewed any of theses certifications please send us a copy for our records. If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}. </span></p>','status' => '1','use_system_email' => '1'),
                                      ]
                        ],
                        ['name' => 'Instructor Certifications Expired Notification','event_key' => 'instructor_certifications_expired_notification','is_schedulable' => '1',
                         'event_variables' => [
                                                array('name' => 'First Name','description' => 'First Name','variable_key' => 'first_name'),
                                                array('name' => 'Last Name','description' => 'Last Name','variable_key' => 'last_name'),
                                                array('name' => 'Course Type','description' => 'Course Type','variable_key' => 'course_type'),
                                                array('name' => 'Course Type Agency','description' => 'Course Type Agency','variable_key' => 'course_type_agency'),
                                                array('name' => 'Instructor Expiry Date','description' => 'Instructor Expiry Date','variable_key' => 'instructor_expiry_date'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                            ],
                          'emails' => [
                                           array('subject' => 'Instructor Certifications Expired Notification','from_name' => '','from_email' => '','body' => '<p><span style="font-weight: 400;">Hi {{first_name}} {{last_name}}- </span></p>
                                              <p><span style="font-weight: 400;">According to our records you have the following certifications that have expired:
                                               </span></p>
                                              <p><span style="font-weight: 400;">Certification Type {{course_type_agency}} {{course_type}} </span></p>
                                              <p><span style="font-weight: 400;">Expiration Date {{instructor_expiry_date}} </span></p>
                                              <p><span style="font-weight: 400;">If you have already renewed any of theses certifications please send us a copy for our records. If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}. </span></p>','status' => '1','use_system_email' => '1'),
                                      ]
                        ],
                        ['name' => 'Account Confirmation Instructor', 'event_key'=> 'account_confirmation_instructor','is_schedulable' => '0',
                        'event_variables' => [
                                              array('name' =>'Instructor Name','description'=>'Instructor Name','variable_key'=>'name'),
                                              array('name' =>'Training Site Name','description'=>'Training Site Name','variable_key'=>'training_site_name'),
                                              array('name' =>'Confirm Url','description'=>'Confirm Url','variable_key'=>'confirm_url'),
                                              array('name' =>'Username','description'=>'Instructor Username','variable_key'=>'username'),
                                              array('name' =>'Server Name','description'=>'Server Name','variable_key'=>'server_name'),
                                              array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                              array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                             ],
                        'emails' => [

                                      array('subject' => 'Account Confirmation Instructor', 'from_name'=> '','from_email'=>'','body'=> '<p>Hi {{name}}- <br />Your instructor account with {{training_site_name}} has been successfully created. You can validate your email using below details.</p>
                                      <p>Email Validation URL: {{confirm_url}}</p>
                                      <p>Username: {{username}}</p>
                                      <p>password: {{password}}</p>
                                      <p>You can login at: {{server_name}}</p>
                                      <p>In the future when courses are available in your region you will receive an training opportunity email. To accept or decline the opportunity login to the instructor portal.</p>
                                      <p>If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}</p>
                                      <p>&nbsp;</p>','status'=>'1','use_system_email'=>'1'),
                                    ]
                        ],
                        ['name' => 'Password Update Tenant', 'event_key'=> 'password_update_tenant','is_schedulable' => '0',
                          'event_variables' => [
                                                 array('name' => 'Tenant User Name','description' => 'Tenant User Name','variable_key' => 'name'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Server Name','description' => 'Server Name','variable_key' => 'server_name'),
                                                array('name' => 'User Name','description' => 'User Name','variable_key' => 'user_name'),
                                                array('name' => 'User Password','description' => 'User Password','variable_key' => 'user_password'),
                                                array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                array('name' => 'Tenant Name','description' => 'Tenant Name','variable_key' => 'tenant_name'),
                                               ],
                          'emails' => [
                                        array('subject' => 'Account Password Update','from_name' => '','from_email' => '', 
                                          'body' => '<p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Hi {{name}}- </span></p>
                                        <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Your Tenant account password has been successfully updated. Your login credentials to our Tenant portal are shown below. </span></p>
                                        <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Tenant Portal URL: <a href="https://{servername}/b/tenants/ ">{{server_name}}tenants/login</a></span></p>
                                        <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Username: {{user_name}} </span></p>
                                        <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Password: {{user_password}} </span></p>
                                        <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">If you have any questions, please contact {{tenant_name}} . <br /></span></p>','status' => '1','use_system_email' => '1'),
                                      ]                     
                        ],
                        ['name' => 'Password Update SuperAdmin', 'event_key' => 'password_update_super_admin','is_schedulable' => '0', 'event_variables' => [
                                                        array('name' => 'Super Admin Name','description' => 'Super Admin Name','variable_key' => 'name'),
                                                        array('name' => 'Server Name','description' => 'Server Name','variable_key' => 'server_name'),
                                                        array('name' => 'User Name','description' => 'User Name','variable_key' => 'user_name'),
                                                        array('name' => 'User Password','description' => 'User Password','variable_key' => 'user_password'),
                                                     ],
                          'emails' => [
                                          array('subject' => 'SuperAdmin password updated!','from_name' => '','from_email' => '','body' => '<p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Hi {{name}}- </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Your Super Admin account password has been successfully updated. Your login credentials to our Super admin portal are shown below. </span></p>
                                            <p>&nbsp;</p>
                                            <p>Super Admin Url : {{servername}}</p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Username: {{user_name}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Password: {{user_password}} <br /></span></p>','status' => '1','use_system_email' => '1'),
                                      ]                           
                          ],
                          ['name' => 'Password Update Student','event_key'=>'password_update_student','is_schedulable'=>'0','event_variables' => [
                                                    array('name' => 'Student Name','description' => 'Student Name','variable_key' => 'name'),
                                                    array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                    array('name' => 'Server Name','description' => 'Server Name','variable_key' => 'server_name'),
                                                    array('name' => 'User Name','description' => 'User Name','variable_key' => 'user_name'),
                                                    array('name' => 'User Password','description' => 'User Password','variable_key' => 'user_password'),
                                                    array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                    array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                ],
                            'emails' => [
                                            array('subject' => 'Account password updated!','from_name' => '','from_email' => '','body' => '<p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Hi {{name}} </span></p>
                                              <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Your Student account with {{training_site_name}} password has been successfully updated. Your login credentials to our student portal are shown below. </span></p>
                                              <p>&nbsp;</p>
                                              <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Tenant Portal URL: <a href="https://{{servername}}/students/login ">https://{{server_name}}/students/login </a></span></p>
                                              <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Username: {{user_name}} </span></p>
                                              <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Password: {{user_password}} </span></p>
                                              <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}} </span></p>','status' => '1','use_system_email' => '1'),
                                        ]                    
                          ],
                          ['name'=> '1 Day Course Reminder Student','event_key' =>'1_day_course_reminder_student','is_schedulable'=>'1','event_variables'=> [
                                                          array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                          array('name' => 'Student Name','description' => 'Student Name','variable_key' => 'name'),
                                                          array('name' => 'Course ID','description' => 'Course ID','variable_key' => 'course_id'),
                                                          array('name' => 'Course Type Agency','description' => 'Course Type Agency','variable_key' => 'course_type_agency'),
                                                          array('name' => 'Course Type ','description' => 'Course Type ','variable_key' => 'course_type'),
                                                          array('name' => 'Course Date','description' => 'Course Date ','variable_key' => 'course_date'),
                                                          array('name' => 'Course Start Time','description' => 'Course Start Time','variable_key' => 'course_start_time'),
                                                          array('name' => 'Course End Time','description' => 'Course End Time','variable_key' => 'course_end_time'),
                                                          array('name' => 'Instructor First Name','description' => 'Instructor First Name','variable_key' => 'instructor_first_name'),
                                                          array('name' => 'Instructor Last Name','description' => 'Instructor Last Name','variable_key' => 'instructor_last_name'),
                                                          array('name' => 'Location Name','description' => 'Location Name','variable_key' => 'location_name'),
                                                          array('name' => 'Location Address','description' => 'Location Address','variable_key' => 'location_address'),
                                                          array('name' => 'Location City','description' => 'Location City','variable_key' => 'location_city'),
                                                          array('name' => 'Location State','description' => 'Location State','variable_key' => 'location_state'),
                                                          array('name' => 'Location Zipcode','description' => 'Location Zipcode','variable_key' => 'location_zipcode'),
                                                          array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                          array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                       ],
                            'emails'=> [
                                           array('subject' => '1 Day Course Reminder','from_name' => '','from_email' => '','body' => '<p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">{{training_site_name}} 1-Day Course Reminder </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Hi {{first_name}} {{last_name}} - </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">This is a friendly reminder about your scheduled class tomorrow with {{training_site_name}}. The class details are shown below. </span></p>
                                            <p>&nbsp;</p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course ID: {{course_id}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Type: {{course_type_agency}} {{course_type}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Date: {{course_date}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Time: {{course_start_time}} - {{course_end_time}}</span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;"> Course Instructor: {{instructor_first_name}} {{instructor_last_name}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Location: {{location_name}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">{{location_address}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">{{location_city}}, {{location_state}}, {{location_zipcode}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">We look forward to seeing you tomorrow! </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">If you have any questions, please contact {{training_site_name}} at {{training_site_email}} or {{training_site_phone}}.</span></p>','status' => '1','use_system_email' => '1'),
                                       ]                           
                          ],
                          ['name'=> '7 Day Course Reminder Instructor', 'event_key'=> '7_day_course_reminder_instructor', 'is_schedulable' => '1','event_variables' => [
                                                                            array('name' => 'Training Site Name','description' => 'Training Site Name','variable_key' => 'training_site_name'),
                                                                            array('name' => 'Instructor First Name','description' => 'Instructor First Name','variable_key' => 'instructor_first_name'),
                                                                            array('name' => 'Instructor Last Name','description' => 'Instructor Last Name','variable_key' => 'instructor_last_name'),
                                                                            array('name' => 'Course Type ','description' => 'Course Type ','variable_key' => 'course_type'),
                                                                            array('name' => 'Course ID','description' => 'Course ID','variable_key' => 'course_id'),
                                                                            array('name' => 'Course Type Agency','description' => 'Course Type Agency','variable_key' => 'course_type_agency'),
                                                                            array('name' => 'Course Date','description' => 'Course Date ','variable_key' => 'course_date'),
                                                                            array('name' => 'Course Start Time','description' => 'Course Start Time','variable_key' => 'course_start_time'),
                                                                            array('name' => 'Course End Time','description' => 'Course End Time','variable_key' => 'course_end_time'),
                                                                            array('name' => 'Location Name','description' => 'Location Name','variable_key' => 'location_name'),
                                                                            array('name' => 'Location Address','description' => 'Location Address','variable_key' => 'location_address'),
                                                                            array('name' => 'Location City','description' => 'Location City','variable_key' => 'location_city'),
                                                                            array('name' => 'Location City','description' => 'Location City','variable_key' => 'location_city'),
                                                                            array('name' => 'Location Zipcode','description' => 'Location Zipcode','variable_key' => 'location_zipcode'),
                                                                            array('name' => 'Location Notes','description' => 'Location Notes','variable_key' => 'location_notes'),
                                                                            array('name' => 'Course Notes','description' => 'Course Notes','variable_key' => 'course_notes'),
                                                                            array('name' => 'Training Site Email','description' => 'Training Site Email','variable_key' => 'training_site_email'),
                                                                            array('name' => 'Training Site Phone','description' => 'Training Site Phone','variable_key' => 'training_site_phone'),
                                                                        ],
                            'emails'=> [
                                          array('subject' => '7 Day Course Reminder','from_name' => '','from_email' => '','body' => '<p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">{{training_site_name}} Training Assignment - 7 Day Reminder </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Hi {{first_name}} {{last_name}}- </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">This is a friendly reminder that you have a training assignment for {{training_site_name}} one week from now. </span></p>
                                            <p>&nbsp;</p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course ID: {{course_id}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Type: {{course_type_agency}} {{course_type}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Date/Time: {{course_date}} | {{course_start_time}} - {{course_end_time}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Location: {{location_name}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Address: {{location_address}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">{{location_city}}, {{location_state}} {{location_zipcode}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Location Notes: {{location_notes}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">Course Notes: {{course_notes}} </span></p>
                                            <p><span style="font-size: 13px; color: #000000; font-weight: normal; text-decoration: none; font-family: \'Arial\'; font-style: normal; text-decoration-skip-ink: none;">If you have any questions, please contact {{training_site_name}} at {{training_site_email}} or {{training_site_phone}}<br /></span></p>','status' => '1','use_system_email' => '1'),
                                       ]                                            
                          ],
                          ['name' => 'Cancel Course','event_key' => 'cancel_course','is_schedulable' => '0','event_variables'=> 
                                [ 
                                    array('name' => 'first name','description' => 'First name of student','variable_key' => 'name'),
                                    array('name' => 'Email','description' => 'email of student','variable_key' => 'email'),
                                    array('name' => 'Course ID','description' => 'ID of course','variable_key' => 'course_id'),
                                    array('name' => 'Course Type','description' => 'course type','variable_key' => 'course_type'),
                                    array('name' => 'Course Type Agency','description' => 'course type agency','variable_key' => 'course_type_agency'),
                                    array('name' => 'Course Date','description' => 'course date','variable_key' => 'course_date'),
                                    array('name' => 'Course Start Time','description' => 'course start time','variable_key' => 'course_start_time'),
                                    array('name' => 'Course End Time','description' => 'course end time','variable_key' => 'course_end_time'),
                                    array('name' => 'Location name','description' => 'Location name','variable_key' => 'location_name'),
                                    array('name' => 'Location address','description' => 'Location address','variable_key' => 'location_address'),
                                    array('name' => 'Location city','description' => 'Location city','variable_key' => 'location_city'),
                                    array('name' => 'Location state','description' => 'Location state','variable_key' => 'location_state'),
                                    array('name' => 'Location zipcode','description' => 'Location zipcode','variable_key' => 'location_zipcode'),
                                    array('name' => 'Training Site name','description' => 'Training Site name','variable_key' => 'training_site_name'),
                                    array('name' => 'Training Site email','description' => 'Training Site email','variable_key' => 'training_site_email'),
                                    array('name' => 'Training Site phone','description' => 'Training Site phone','variable_key' => 'training_site_phone'),
                                    array('name' => 'Instructor name','description' => 'First name of Instructor','variable_key' => 'instructor_name'),
                                    array('name' => 'Instructor email','description' => 'email of Instructor','variable_key' => 'instructor_email'),
                                ],
                          'emails'=> [
                                         array('subject' => 'Course Cancellation Notification','from_name' => '','from_email' => '','body' => '<p>Hi {{name}}-</p>
                                        <p>A course that was assigned to you has been cancelled.</p>
                                        <p>Course ID: {{course_id}}<br />Course Date/Time: {{course_date}} | {{course_start_time}} - {{course_end_time}}<br />Course Type: {{course_type_agency}} {{course_type}}<br />Course Location: {{location_name}}, {{location_address}}, {{location_city}}, {{location_state}}, {{location_zipcode}}</p>
                                        <p>If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}</p>','status' => '1','use_system_email' => '1'),
                                     ]  
                          ],
                          ['name' => 'Registration Confirmation','event_key' => 'corporate_admin_registration','is_schedulable' => '0','event_variables' => [
                                                          array('name' => 'Name','description' => 'name of corporate client','variable_key' => 'name'),
                                                          array('name' => 'Email','description' => 'Email of corporate client','variable_key' => 'email'),
                                                          array('name' => 'Username','description' => 'Username of corporate client','variable_key' => 'username'),
                                                          array('name' => 'Password','description' => 'password of corporate client','variable_key' => 'password'),
                                                          array('name' => 'Server Name','description' => 'server name for corporate client','variable_key' => 'server_name'),
                                                          array('name' => 'Training Site name','description' => 'Training Site name','variable_key' => 'training_site_name'),
                                                          array('name' => 'Training Site phone','description' => 'Training Site phone','variable_key' => 'training_site_phone'),
                                                          array('name' => 'Training Site email','description' => 'Training Site email','variable_key' => 'training_site_email'),

                                                        ],
                           'emails' => [
                                           array('subject' => 'Registration Confirmation For Corporate Client','from_name' => '','from_email' => '','body' => '<p>Hi {{name}}<br />You have been registered as an corporate admin with {{training_site_name}}.</p>
                                          <p>Your username is: {{username}}</p>
                                          <p>Your password is: {{password}}</p>
                                          <p>You can login at: http://{{server_name}}</p>
                                          <p><br/>If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}</p>','status' => '1','use_system_email' => '1'),
                                       ]                             
                          ],
                          ['name' => 'Instructor Accept Course','event_key' => 'instructor_accept_course','is_schedulable' => '0','event_variables' => [
                                                     array('name' => 'first name','description' => 'First name of Instructor','variable_key' => 'name'),
                                                    array('name' => 'Email','description' => 'email of student','variable_key' => 'email'),
                                                    array('name' => 'Course ID','description' => 'ID of course','variable_key' => 'course_id'),
                                                    array('name' => 'Course Date','description' => 'course date','variable_key' => 'course_date'),
                                                    array('name' => 'Course Start Time','description' => 'course start time','variable_key' => 'course_start_time'),
                                                    array('name' => 'Course End Time','description' => 'course end time','variable_key' => 'course_end_time'),
                                                    array('name' => 'Location name','description' => 'Location name','variable_key' => 'location_name'),
                                                    array('name' => 'Location address','description' => 'Location address','variable_key' => 'location_address'),
                                                    array('name' => 'Location city','description' => 'Location city','variable_key' => 'location_city'),
                                                    array('name' => 'Location state','description' => 'Location state','variable_key' => 'location_state'),
                                                    array('name' => 'Training Site name','description' => 'Training Site name','variable_key' => 'training_site_name'),
                                                    array('name' => 'Training Site email','description' => 'Training Site email','variable_key' => 'training_site_email'),
                                                    array('name' => 'Training Site phone','description' => 'Training Site phone','variable_key' => 'training_site_phone'),
                                                    array('name' => 'Instructor Notes','description' => 'notes for instructor','variable_key' => 'instructor_notes'),
                                                    array('name' => 'Course Notes','description' => 'course Details','variable_key' => 'course_notes'),
                                                    array('name' => 'Location Notes','description' => 'Location Notes','variable_key' => 'location_notes'),
                                                  ],
                           'emails' => [
                                           array('subject' => '{{training_site_name}} - Course Accepted','from_name' => '','from_email' => '','body' => '<p>Dear {{name}},</p>
                                            <p>A course that was offered to you by {{training_site_name}} has been accepted.<br />This means that the course has been assigned to you and you are expected to be there on {{course_date}} at {{course_start_time}} to teach the course.</p>
                                            <p>Course ID: {{course_id}}<br />Course Date: {{course_date}}<br />Course Time: {{course_start_time}} - {{course_end_time}}<br />Location: {{location_name}}<br />Address: {{location_address}} , {{location_address}}, {{location_state}}</p>
                                            <p>Course Notes: {{course_notes}}</p>
                                            <p>Location Notes: {{location_notes}}</p>
                                            <p>Instructor Notes: {{instructor_notes}}</p>
                                            <p>If you do not agree with this, please contact us immediately.</p>
                                            <p><br/>If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}</p>','status' => '1','use_system_email' => '1'),
                                       ]                       
                          ],
                          ['name' => 'Instructor Decline Course','event_key' => 'instructor_decline_course','is_schedulable' => '0','event_variables' => [
                                                      array('name' => 'first name','description' => 'First name of Instructor','variable_key' => 'name'),
                                                      array('name' => 'Email','description' => 'email of student','variable_key' => 'email'),
                                                      array('name' => 'Course ID','description' => 'ID of course','variable_key' => 'course_id'),
                                                      array('name' => 'Course Date','description' => 'course date','variable_key' => 'course_date'),
                                                      array('name' => 'Course Start Time','description' => 'course start time','variable_key' => 'course_start_time'),
                                                      array('name' => 'Course End Time','description' => 'course end time','variable_key' => 'course_end_time'),
                                                      array('name' => 'Location name','description' => 'Location name','variable_key' => 'location_name'),
                                                      array('name' => 'Location address','description' => 'Location address','variable_key' => 'location_address'),
                                                      array('name' => 'Location city','description' => 'Location city','variable_key' => 'location_city'),
                                                      array('name' => 'Location state','description' => 'Location state','variable_key' => 'location_state'),
                                                      array('name' => 'Training Site name','description' => 'Training Site name','variable_key' => 'training_site_name'),
                                                      array('name' => 'Training Site email','description' => 'Training Site email','variable_key' => 'training_site_email'),
                                                      array('name' => 'Training Site phone','description' => 'Training Site phone','variable_key' => 'training_site_phone'),
                                                      array('name' => 'Instructor Notes','description' => 'notes for instructor','variable_key' => 'instructor_notes'),
                                                      array('name' => 'Course Notes','description' => 'course Details','variable_key' => 'course_notes'),
                                                      array('name' => 'Location Notes','description' => 'Location Notes','variable_key' => 'location_notes'),
                                                    ],
                           'emails' => [
                                           array('subject' => '{{training_site_name}} - Course Declined','from_name' => '','from_email' => '','body' => '<p>Dear {{name}},</p>
                                          <p>A course that was offered to you by {{training_site_name}} has been declined.<br />This means that you or someone on your behalf rejected this course.</p>
                                          <p>Course ID: {{course_id}}<br />Course Date: {{course_date}}<br />Course Time: {{course_start_time}} - {{course_end_time}}<br />Location: {{location_name}}<br />Address: {{location_address}} , {{location_address}}, {{location_state}}</p>
                                          <p>Course Notes: {{course_notes}}</p>
                                          <p>Location Notes: {{location_notes}}</p>
                                          <p>Instructor Notes: {{instructor_notes}}</p>
                                          <p>If you do not agree with this, please contact us immediately.</p>
                                          <p><br/>If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}</p>','status' => '1','use_system_email' => '1'),
                                       ]                         
                          ],
                          ['name' => 'Register Student to course','event_key' => 'register_student_to_course','is_schedulable' => '0','event_variables' => [
                                                          array('name' => 'first name','description' => 'First name of student','variable_key' => 'name'),
                                                          array('name' => 'Email','description' => 'email of student','variable_key' => 'email'),
                                                          array('name' => 'Course ID','description' => 'ID of course','variable_key' => 'course_id'),
                                                          array('name' => 'Course Type','description' => 'course type','variable_key' => 'course_type'),
                                                          array('name' => 'Course Type Agency','description' => 'course type agency','variable_key' => 'course_type_agency'),
                                                          array('name' => 'Course Date','description' => 'course date','variable_key' => 'course_date'),
                                                          array('name' => 'Course Start Time','description' => 'course start time','variable_key' => 'course_start_time'),
                                                          array('name' => 'Course End Time','description' => 'course end time','variable_key' => 'course_end_time'),
                                                          array('name' => 'Location name','description' => 'Location name','variable_key' => 'location_name'),
                                                          array('name' => 'Location address','description' => 'Location address','variable_key' => 'location_address'),
                                                          array('name' => 'Location city','description' => 'Location city','variable_key' => 'location_city'),
                                                          array('name' => 'Location state','description' => 'Location state','variable_key' => 'location_state'),
                                                          array('name' => 'Location zipcode','description' => 'Location zipcode','variable_key' => 'location_zipcode'),
                                                          array('name' => 'Training Site name','description' => 'Training Site name','variable_key' => 'training_site_name'),
                                                          array('name' => 'Training Site email','description' => 'Training Site email','variable_key' => 'training_site_email'),
                                                          array('name' => 'Training Site phone','description' => 'Training Site phone','variable_key' => 'training_site_phone'),
                                                          array('name' => 'Server Name','description' => 'server name for student','variable_key' => 'server_name'),
                                                          array('name' => 'Server Name','description' => 'server name for student','variable_key' => 'to_login'),
                                                          array('name' => 'Username','description' => 'Username of student','variable_key' => 'username'),
                                                          array('name' => 'Password','description' => 'password of student','variable_key' => 'password'),
                                                          array('name' => 'email content for student','description' => 'email content of student','variable_key' => 'email_content'),
                                                      ],
                           'emails'=> [
                                          array('subject' => 'Payment Reminder from {{training_site_name}}','from_name' => '','from_email' => '','body' => '<p>Hi {{name}}-</p>
                                          <p>{{email_content}}</p>
                                          <p>{{username}}</p>
                                          <p>{{password}}</p>
                                          <p>{{to_login}}</p>
                                          <p>You recently registered for a course offered by {{training_site_name}}, however our records show that payment has not been received for this course. The course details and payment instructions are shown below.</p>
                                          <p>Course ID: {{course_id}}</p>
                                          <p>Course Type: {{course_type_agency}} {{course_type}}</p>
                                          <p>Course Date/Time: {{course_date}} | {{course_start_time}} - {{course_end_time}}</p>
                                          <p>Course Location: {{location_name}}</p>
                                          <p>Course Address: {{location_address}}, {{location_city}}, {{location_state}} {{location_zipcode}}</p>
                                          <p>To remit payment for this course please click on the link below:</p>
                                          <p>{{server_name}}</p>
                                          <p>If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}</p>','status' => '1','use_system_email' => '1'),
                                      ]                           
                          ],
                          ['name' => 'Refund Student','event_key' => 'refund_student','is_schedulable' => '0','event_variables'=>    [
                                    array('name' => 'first name','description' => 'First name of student','variable_key' => 'name'),
                                    array('name' => 'Email','description' => 'email of student','variable_key' => 'email'),
                                    array('name' => 'Course ID','description' => 'ID of course','variable_key' => 'course_id'),
                                    array('name' => 'Course Type','description' => 'course type','variable_key' => 'course_type'),
                                    array('name' => 'Course Type Agency','description' => 'course type agency','variable_key' => 'course_type_agency'),
                                    array('name' => 'Course Date','description' => 'course date','variable_key' => 'course_date'),
                                    array('name' => 'Course Start Time','description' => 'course start time','variable_key' => 'course_start_time'),
                                    array('name' => 'Course End Time','description' => 'course end time','variable_key' => 'course_end_time'),
                                    array('name' => 'Location name','description' => 'Location name','variable_key' => 'location_name'),
                                    array('name' => 'Location address','description' => 'Location address','variable_key' => 'location_address'),
                                    array('name' => 'Location city','description' => 'Location city','variable_key' => 'location_city'),
                                    array('name' => 'Location state','description' => 'Location state','variable_key' => 'location_state'),
                                    array('name' => 'Location zipcode','description' => 'Location zipcode','variable_key' => 'location_zipcode'),
                                    array('name' => 'Training Site name','description' => 'Training Site name','variable_key' => 'training_site_name'),
                                    array('name' => 'Training Site email','description' => 'Training Site email','variable_key' => 'training_site_email'),
                                    array('name' => 'Training Site phone','description' => 'Training Site phone','variable_key' => 'training_site_phone'),
                                    array('name' => 'Refund Dtae','description' => 'date of refund','variable_key' => 'refund_date'),
                                    array('name' => 'Refund method','description' => 'Method of refund','variable_key' => 'refund_method'),
                                    array('name' => 'Refund amount','description' => 'amount of refund','variable_key' => 'refund_amount'),
                                    array('name' => 'original amount','description' => 'original amount of refund','variable_key' => 'original_amount'),
                                ],
                            'emails' => [
                                            array('subject' => 'Payment Refund Confirmation From {{training_site_name}}','from_name' => '','from_email' => '','body' => '<p>Hi {{name}}-</p>
                                            <p>Your course cancellation has been processed, any applicable refund has been issued for the course below.</p>
                                            <p>PAYMENT REFUND RECEIPT</p>
                                            <p>Date of Refund: {{refund_date}}</p>
                                            <p>Refund Method: {{refund_method}}</p>
                                            <p>Original Payment Amount: $ {{original_amount}}</p>
                                            <p>Refund Amount: $ {{refund_amount}}</p>
                                            <p>Course ID: {{course_id}}<br />Course Date/Time: {{course_date}} | {{course_start_time}} - {{course_end_time}}<br />Course Type: {{course_type_agency}} {{course_type}}<br />Course Location: {{location_name}}, {{location_address}}, {{location_city}}, {{location_state}}, {{location_zipcode}}</p>
                                            <p>If you have any questions, please contact {{training_site_name}} at {{training_site_phone}} or {{training_site_email}}</p>','status' => '1','use_system_email' => '1'),
                                        ]    
                          ],

                          ['name' => 'Share Courses Tenants', 'event_key'=> 'share_course','is_schedulable' => '0',
                        'event_variables' => [
                                              array('name' =>'Center Name','description'=>'Center Name','variable_key'=>'center_name'),
                                              array('name' =>'Email','description'=>'Email','variable_key'=>'email'),
                                              array('name' =>'Accept link','description'=>'Accept link','variable_key'=>'accept_link'),
                                              array('name' =>'Decline Link','description'=>'Decline Link','variable_key'=>'decline_link'),
                                              array('name' =>'course ID','description'=>'course ID','variable_key'=>'course_id'),
                                              array('name' => 'Course Name','description' => 'Course Name','variable_key' => 'course_name'),
                                              array('name' => 'Assigner Tenant Name','description' => 'Assigner Tenant Name','variable_key' => 'assigner_center_name'),
                                             ],
                        'emails' => [

                                      array('subject' => '{{assigner_center_name}} shared a course with you', 'from_name'=> '','from_email'=> null,'body'=> '<p>Hi {{center_name}},</p>
                                                  <p>{{assigner_center_name}} has shared a course with you.</p>
                                                  <p>Course name : {{course_name}}</p>
                                                  <p>If you want to accept this course please click on this link {{accept_link}} or if you want to decline please click on this link {{decline_link}}.</p>
                                                  <p>Thank you,<br />ClassByte Support Team</p>','status'=>'1','use_system_email'=>'1'),
                                    ]
                        ],

                        ['name' => 'revoke Courses Access', 'event_key'=> 'revoke_access_for_course','is_schedulable' => '0',
                        'event_variables' => [
                                              array('name' =>'Center Name','description'=>'Center Name','variable_key'=>'center_name'),
                                              array('name' =>'Email','description'=>'Email','variable_key'=>'email'),
                                              array('name' =>'course ID','description'=>'course ID','variable_key'=>'course_id'),
                                              array('name' => 'Course Name','description' => 'Course Name','variable_key' => 'course_name'),
                                              array('name' => 'Assigner Tenant Name','description' => 'Assigner Tenant Name','variable_key' => 'assigner_center_name'),
                                              array('name' => 'Assigner Tenant Email','description' => 'Assigner Tenant Email','variable_key' => 'assigner_email'),
                                             ],
                        'emails' => [

                                      array('subject' => 'Access for Course Revoked!', 'from_name'=> '','from_email'=> null,'body'=> '<p>Hi {{center_name}},</p>
                                                  <p>{{assigner_center_name}} has revoked access for the course shared with you.</p>
                                                  <p>Course name : {{course_name}}</p>
                                                  <p>For any queries, please contact {{assigner_email}}.</p>
                                                  <p>Thank you,<br />ClassByte Support Team</p>','status'=>'1','use_system_email'=>'1'),
                                    ]
                        ],


                          ['name' => 'one day reminder','event_key' => 'one_day_reminder_instructor','is_schedulable' => '1','event_variables' => [
                                                    array('name' => 'first name','description' => 'First name of instructor','variable_key' => 'name'),
                                                    array('name' => 'Email','description' => 'email of instructor','variable_key' => 'email'),
                                                    array('name' => 'Course ID','description' => 'ID of course','variable_key' => 'course_id'),
                                                    array('name' => 'Course Type','description' => 'course type','variable_key' => 'course_type'),
                                                    array('name' => 'Course Type Agency','description' => 'course type agency','variable_key' => 'course_type_agency'),
                                                    array('name' => 'Course Type Agency','description' => 'course type agency','variable_key' => 'course_type_agency'),
                                                    array('name' => 'Course Date','description' => 'course date','variable_key' => 'course_date'),
                                                    array('name' => 'Course Start Time','description' => 'course start time','variable_key' => 'course_start_time'),
                                                    array('name' => 'Course End Time','description' => 'course end time','variable_key' => 'course_end_time'),
                                                    array('name' => 'Location name','description' => 'Location name','variable_key' => 'location_name'),
                                                    array('name' => 'Location address','description' => 'Location address','variable_key' => 'location_address'),
                                                    array('name' => 'Location city','description' => 'Location city','variable_key' => 'location_city'),
                                                    array('name' => 'Location state','description' => 'Location state','variable_key' => 'location_state'),
                                                    array('name' => 'Location zipcode','description' => 'Location zipcode','variable_key' => 'location_zipcode'),
                                                    array('name' => 'Training Site name','description' => 'Training Site name','variable_key' => 'training_site_name'),
                                                    array('name' => 'Training Site email','description' => 'Training Site email','variable_key' => 'training_site_email'),
                                                    array('name' => 'Training Site phone','description' => 'Training Site phone','variable_key' => 'training_site_phone'),
                                                ],
                           'emails' => [
                                           array('subject' => '1 Day Assignment Reminder From {{training_site_name}}','from_name' => '','from_email' => '','body' => '<p>{{training_site_name}} Training Assignment - 1 Day Reminder</p>
                                          <p>Hi {{name}}-</p>
                                          <p>This is a friendly reminder that you have a training assignment for {{training_site_name}} tomorrow. Please click on the confirmation link below to confirm you are prepared to cover this assignment:</p>
                                          <p>{{confirmation_url}}</p>
                                          <p>Course Details<br />Course ID: {{course_id}}<br />Course Type: {{course_type_agency}} {{course_type}}<br />Course Date: {{course_date}}<br />Course Time: {course_start_time} - {course_end_time}<br />Course Location: {{location_name}}<br />{{location_address}}<br />{{location_city}}, {{location_state}} {{location_zipcode}}</p>
                                          <p>Location Notes: {{location_notes}}</p>
                                          <p>Course Notes: {{course_notes}}</p>
                                          <p>If you have any questions, please contact {{training_site_name}} at {{training_site_email}} or {{training_site_phone}}</p>','status' => '1','use_system_email' => '1'),
                                       ]                     
                          ]

            ]
    ]
?>