/**********************************/
/*               VARS             */
/**********************************/
$(document).ready(function() {
	
    /**************************************/
    /*       AUTOCOMPLETE GEOCODER        */
    /**************************************/
    var formatResult = function (feature, el) {
    var title = document.createElement("strong");
    el.appendChild(title);
    var detailsContainer = document.createElement("small");
    el.appendChild(detailsContainer);
    var details = [];
    title.innerHTML = feature.properties.label || feature.properties.name;
    var types = {
      housenumber: "numéro",
      street: "rue",
      locality: "lieu-dit",
      municipality: "commune",
    };
    if (types[feature.properties.type]) {
      var spanType = document.createElement("span");
      spanType.className = "type";
      title.appendChild(spanType);
      spanType.innerHTML = types[feature.properties.type];
    }
    if (
      feature.properties.city &&
      feature.properties.city !== feature.properties.name
    ) {
      details.push(feature.properties.city);
    }
    if (feature.properties.context) {
      details.push(feature.properties.context);
    }
    detailsContainer.innerHTML = details.join(",");
  };

    var container_address = new Photon.Search({
      resultsHandler: addressHandler,
      onSelected: onSelected_address,
      placeholder: "Saissiez une ville, code postal ou adresse",
      formatResult: formatResult,
      url: API_URL + "/search/?",
      feedbackEmail: null,
      limit:10,
      minChar:5
    });
    $('#mapid_address').append(container_address);
    $('#mapid_address input').addClass('mandatoryfield');
    $('#mapid_address input').addClass('fieldoutline');
    $('#mapid_address input').addClass('fullW');
    $('#mapid_address input').attr('id','mapid_address_photon');

    if($("#user_address").val() != ""){
      $('#mapid_address input').val( $("#user_address").val() );
      $("#mapid_address input").addClass("fieldcomplited");
      $("#mapid_address input").removeClass("error");
    }

    
    var container_address2 = new Photon.Search({
      resultsHandler: addressHandler,
      onSelected: onSelected_address2,
      placeholder: "Saissiez une ville, code postal ou adresse",
      formatResult: formatResult,
      url: API_URL + "/search/?",
      feedbackEmail: null,
      limit:10,
      minChar:5
    });
    $('#mapid_address2').append(container_address2);
    $('#mapid_address2 input').addClass('mandatoryfield');
    $('#mapid_address2 input').addClass('fieldoutline');
    $('#mapid_address2 input').addClass('fullW');
    $('#mapid_address2 input').attr('id','mapid_address2_photon');

    if($("#user_address2").val() != ""){
      $('#mapid_address2 input').val( $("#user_address2").val() );
      $("#mapid_address2 input").addClass("fieldcomplited");
      $("#mapid_address2 input").removeClass("error");
    }

    

});

function onSelected_address(feature) {
    console.log(feature);
  $("#mapid_address input").val(feature.properties.label);
  $("#mapid_address input").addClass("fieldcomplited");
  $("#mapid_address input").removeClass("error");
  $('#user_address').val(feature.properties.label);
  $('#user_zipcode').val(feature.properties.postcode);
  $('#user_city').val(feature.properties.city);
  $('#user_street').val(feature.properties.street);
}

function onSelected_address2(feature) {
  $("#mapid_address2 input").val(feature.properties.label);
  $("#mapid_address2 input").addClass("fieldcomplited");
  $("#mapid_address2 input").removeClass("error");
  $('#user_address2').val(feature.properties.label);
  $('#user_zipcode2').val(feature.properties.postcode);
  $('#user_city2').val(feature.properties.city);
  $('#user_street2').val(feature.properties.street);
}

function addressHandler(featureCollection) {
  //if(featureCollection.features.length == 0)
    //$('#mapid_stationnement').find("input").val($('#mapid_stationnement').find("input").val().substring(0, $('#mapid_stationnement').find("input").val().length - 1));
}

$(window).on('load', function() {
	
});
