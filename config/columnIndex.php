<?php
use Cake\Core\Configure;
  return [ 
          'Courses' => [
                          'course_id',
                          'no_of_students',
                          'agency',
                          "course_type",
                          "corporate_client",
                          "training_site",
                          "date",
                          "status",
                          "location",
                          "city",
                          "state",
                          "instructor_status",
                        ],
          'Students' => [
                          'training_site',
                          'corporate_client',
                          'subcontracted_client',
                          'first_name',
                          "last_name",
                          "status",
                          "email",
                          "phone1",
                          "city",
                          "state",
                        ],
          'TrainingSites' => [
                                'training_site',
                                'site_name',
                                'contact',
                                'email',
                                "phone",
                                "document_and_notes",
                                "city",
                                "state",
                              ],
          'CorporateClients' => [
                                  'client_name',
                                  "document_and_notes",
                                  "city",
                                  "state",
                                  "zipcode",
                                  "status"
                                ],
          'Instructors' => [
                              'first_name',
                              "last_name",
                              "email",
                              "status",
                              "document_and_qualifications",
                              "phone",
                              "city",
                              "state",
                            ],
          'Locations' => [
                            'corporate_client',
                            "location_name",
                            "city",
                            "state",
                            'zipcode'
                          ],
          'ReopenCourses' => [
                            'course_id',
                            "training_site",
                            "agency",
                            "course_type",
                          ],                                               
    ]
?>
