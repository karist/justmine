$(document).ready(function(){
  var json_source = [
      {"model" : "Iphone 18", "name" : "iOS", "share" : 57.56},
      {"model" : "Nexus 23", "name" : "Android", "share" : 24.66},
      {"model" : "Tom-tom", "name" : "Java ME", "share" : 10.72},
      {"model" : "Nokia 66610", "name" : "Symbian", "share" : 2.49},
      {"model" : "Blackberry", "name" : "Blackberry", "share" : 2.26},
      {"model" : "Lumia", "name" : "Windows Phone", "share" : 1.33}
  ];
  
  var options = {
      source: json_source,
      rowClass: "classy",
      callback: function(){
          alert("Table generated!");
      }
  };
  
  ///////////////////////////////
  // Test on a pre-existing table
  // $("#dataTable").jsonTable({
  //     head : ['Model','Operating System','Market Share'],
  //     json : ['model', 'name', 'share']
  // });

  // $("#dataTable").jsonTableUpdate(options);
  
  ///////////////////////////////
  // Test on a table not yet attached to the DOM
  var testTable = $("<table border=1></table>");

  testTable.jsonTable({
      head : ['N.', 
              'Code', 
              {'name': 'phone', 
               'subcol':['Model',
                         {'name':'Vendor',
                          'subcol':['Lokal', 'Luar', 'Unknown']},
                         {'name':'brain', 
                          'subcol':['Versi',
                                   {'name':'OS', 
                                    'subcol':['Operating',
                                               'System']
                                   },
                                    {'name': 'harga',
                                     'subcol': ['Dollar', 'Rupiah']}]
                          }]},
              {'name': 'status', 
               'subcol':
                        [ 'new',
                           'second']},
              'Market Share'],
      // head : ['N.', 'Model', 'Operating System','Market Share'],
      json : ['*', '','model', 'name', '','','share','','','','','','',''] // The '*' identity will be incremented at each line
  });

  testTable.jsonTableUpdate(options);

  $("#container").append(testTable);
});