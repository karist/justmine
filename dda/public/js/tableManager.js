(function ( $ ) {
    // fungsi untuk mendapatkan daftar judul kolom, hanya yang berada persis di atas nomor kolom
    function colnamesAll(subMenuItems) {
        if (subMenuItems) {
          var arr = [];
          for (var i = 0; i < subMenuItems.length; i++) {
            if (typeof subMenuItems[i] != null && typeof subMenuItems[i] === 'object') {
              var found = colnamesAll(subMenuItems[i].subcol);
              arr.push(subMenuItems[i].name);
              arr = arr.concat(found);
            } else {
              arr.push(subMenuItems[i]);
            }   
          }
          return arr;
        }
    }; 
    window.colnamesAll = colnamesAll;

    // fungsi untuk mendapatkan daftar judul kolom, termasuk nama objeknya
    function colnames(subMenuItems) {
        if (subMenuItems) {
            var arr = [];
            for (var i = 0; i < subMenuItems.length; i++) {
                if (typeof subMenuItems[i] != null && typeof subMenuItems[i] === 'object') {
                    var found = colnames(subMenuItems[i].subcol);
                    arr = arr.concat(found);
                } else {
                    arr.push(subMenuItems[i]);
                }
            }
            return arr;
        }
    }; 
    window.colnames = colnames;

    function update(source, container){
        var stub = source.table.stubname;
        var column = source.table.column;
        var kolom = stub.concat(column);
        
        var options = {
            source: source.data,
            rowClass: "classy",
            callback: function(){}
        };
        var testTable = $("<table></table>");
        var keys = kolom;
        testTable.jsonTable({
            head : kolom,
            json : keys // The '*' identity will be incremented at each line
        });
        testTable.jsonTableUpdate(options);
        $("#"+container).empty();
        $("#"+container).append(testTable);
    }
    window.update = update;

    function getData(source) {
        var stub = source.table.stubname;
        var column = source.table.column;
        var col = stub.concat(column);
        var row = source.table.stub;
        var data2 = [];
        var colname = colnames(col);
        for(i = 0 ; i < row.length ; i++){
            var obj = {};
            for(j = 0; j < colname.length; j++){
                if(j==0){
                    obj[stub] = row[i];
                } else {
                    var myVar = colname[j];
                    obj[myVar] = "";
                }
            }
            data2.push(obj);
        }
        return data2;
    }
    window.getData = getData;

    function init(source){
        $('#tabno').val(source.tableheader.tabno);
        $('#tabname').val(source.tableheader.tabname);
        $('#tabtitle').val(source.tableheader.tabtitle);
        $('#sumber').val(source.tablefooter.sumber);
    }
    window.init = init;
}( jQuery ));
 
