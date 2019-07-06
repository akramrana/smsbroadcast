/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var app = {
    changeClientNumberList: function (client_id) {
        var newSourceUrl = baseUrl + 'client-campaign/get-numbers?client_id=' + client_id;
        var oTable = $('#phone-listing').DataTable();
        oTable.ajax.url(newSourceUrl);
        oTable.draw();
    }
}

