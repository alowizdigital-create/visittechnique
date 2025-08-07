(function(){

	var smsDestFile = document.getElementById('smsSelectDestFile');
	var contacts = '';
	var smsDestPhones = document.getElementById('new-sms-phone');
	if (!smsDestFile) {
		return;
	}

	smsDestFile.addEventListener('change', function(){
		if (!!smsDestFile.files && smsDestFile.files.length > 0) {
			parseSmsContactCSV(smsDestFile.files[0]);
		}
	});

	function parseSmsContactCSV(file){
		
		if (!file || !FileReader) {
			return;
		}

		var reader = new FileReader();

		reader.onload = function(e){
			//parseContacts(e.target.result);
			getPhoneNumbers(e.target.result);
		}

		reader.readAsText(file);
	}

	function getPhoneNumbers(contacts)
	{
		let rows = contacts.split('\n');
		const phones = [];
		rows.forEach(function(row) {
			let line = row.split(';');
			line[0] = line[0].replaceAll(/\s+/g, '');
	    line[0] = line[0].replaceAll('/', ';');
	    line[0] = line[0].replaceAll(',', ';');
	    line[0] = line[0].replaceAll('-', ';');
	    if (line[0].length >= 9 ) {
	      let phone = line[0].split(';');
	     
	      for (var i = phone.length - 1; i >= 0; i--) {
	        if(phone[i].length >=9 && !isNaN(phone[i])) {
	          // vérifie si le numéro existe déjà ou pas
	          if (!phones.includes(phone[i])){
	            phones[phones.length] = phone[i];
	          }
	        }
	      }
	    }
	  });

		//smsDestPhones.val(phones);
		console.dir(phones);
	  //return phones;
	}


	function parseContacts(contacts){
		let rows = contacts.split('\n');
		console.dir("Nombre de contacts : " + rows.length);
	}
})();