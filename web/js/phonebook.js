// Телефонный номер контакта
class Phone {
	constructor(contact, id) {	
		this.id = id;
		this.number = "";
		this.contact = contact;
	}
	
	// Сменить наименование контакта
	changeNumber(newNumber) {
		this.number = newNumber;
	}	
}


// Контакт телефонной книги
class Contact {
	constructor(id) {	
		this.id = id;
		this.name = "";
		this.phones = [];
	}

	// Сменить наименование контакта
	changeName(newName) {
		this.name = newName;
	}
	
	// Добавить номер телефона
	addPhone(newPhone) {
		if (newPhone instanceof Phone) {
			this.phones.push(newPhone);
		} else {
			alert("Добавляемый номер не является номером телефона");
		}
	}
}

class App {
	constructor() {
		// Телефонная книга
		this.contactList = [];
		this.reloadContactList();		
	}
	
	addContact(contact) {
		if (contact instanceof Contact) {
			this.contactList.push(contact);
		}
	}	
	

	reloadContactList() {
		let _app = this;
		this.contactList = [];
	
		$.post("/contact/list", function( list ) {
			for(let contact_key in list) {
				let contact = list[contact_key];
				let tmp_contact = new Contact(contact.id);
				console.log(contact);
				
				// Задаем наименование контакта
				tmp_contact.changeName(contact.name);
				
				// Задаем телефоны
				for(let phone_key in contact.phones) {	
					let phone = contact.phones[phone_key];
					let tmp_phone = new Phone(tmp_contact, phone.id);
					tmp_phone.changeNumber(phone.phone);
					tmp_contact.addPhone(tmp_phone);
				}
				
				_app.addContact(tmp_contact);
			}
			
			console.log(_app);
			_app.reRenderContactList();
		});
	}	

	
	hideContactsBySearchCondition(text) {
		$("tr").removeClass('hidden_by_search');	
	
		if (text != "") {
			for(let contact_key in this.contactList) {
				let contact = this.contactList[contact_key];
				let isNameSatisfySearchFlag = (contact.name.indexOf(text) != -1);

				let isPhoneSatisfySearchFlag = false;
				for(let phone_key in contact.phones) {
					let phone = contact.phones[phone_key];
					if (phone.number.indexOf(text) != -1) {
						isPhoneSatisfySearchFlag = true;
						break;
					}
				}
				
				if (!isNameSatisfySearchFlag && !isPhoneSatisfySearchFlag) {
					$('div.contact_name[data-id="' + contact.id + '"]').parent().parent().addClass('hidden_by_search');
				}
			}
		}
	}
	
	// --------------------
	 
	// Перерисовать список контактов
	reRenderContactList() {
		let _app = this;
		this.clearContactTable();
		
		for(let contact_key in this.contactList) {
			let contact = this.contactList[contact_key];
			
			let _tr = $('<tr>');
			let _td = $('<td>');
			
			_tr.append($('<td>')
				.append($('<div>', { 
					text: contact.name,
					'data-id': contact.id,
					 class: "contact_name",
				}))
			);
			
			let _div_contact_phones = $('<div>', { 
				class: "contact_phones",
				'data-contactid': contact.id,
			});
			
			// Добавляем телефоны
			for(let phone_key in contact.phones) {
				let _div_contact_phones_container = $('<div>', { 
					class: "contact_phone_container",
					'data-contactid': contact.id,
					'data-phoneid': contact.phones[phone_key].id,
				});
				
				let _div_contact_phone = $('<div>', { 
					text: contact.phones[phone_key].number,
					class: "contact_phone",
					'data-contactid': contact.id,
					'data-phoneid': contact.phones[phone_key].id,
				});
				
				let _div_delete_phone = $('<div>', {
					text: "x",
					class: "contact_phone_delete",
					'data-contactid': contact.id,
					'data-phoneid': contact.phones[phone_key].id,
					click: function() {
						if (!confirm("Вы действительно хотите удалить этот телефон?"))
							return;
							
						let _this = $(this);
						let phone_id = _this.data('phoneid');

						$.get("/contact/deletephone", {id: phone_id}, function( list ) {	
							if (list && list.result != 'error') {
								// Удаляем из представления
								$('.contact_phone_container[data-contactid="' + contact.id + '"][data-phoneid="' + phone_id + '"]').remove();
								
								// Удаляем из модели
								let findedContact = (_app.contactList.find(x => x.id == contact.id));
								if (findedContact instanceof Contact) {
									let findedPhone = findedContact.phones.find(x => x.id == phone_id);
									if (findedPhone instanceof Phone) {
										let findedPhoneIndex = findedContact.phones.indexOf(findedPhone);
										findedContact.phones.splice(findedPhoneIndex, 1);
									}
								}
							}
						});
					}
				});				
				
				_div_contact_phones_container
					.append(_div_contact_phone)
					.append(_div_delete_phone);
					
				_div_contact_phones.append(_div_contact_phones_container);
			}
			
			_td.append(_div_contact_phones);
			
			_tr.append(_td);
			
			
			_tr.append($('<td>')
				.append($('<div class="action_container">')
					.append($('<a>', {
						text: 'Доб.тел.',
						'data-contactid': contact.id,
						click: function() {
							let _id = contact.id;
							$("#addphone_contact_id").val(_id);
							$('#modalAddPhone').modal('show');
						}
					}))
				)			
				.append($('<div class="action_container">')
					.append($('<a>', {
						text: 'Редактировать',
						'data-contactid': contact.id,
						click: function() {
							let _id = contact.id;
							let _name = contact.name;
						
							$("#editcontact_id").val(_id);
							$("#editcontact_name").val(_name);
							$('#modalEditContact').modal('show');
						}
					}))
				)
				.append($('<div class="action_container">')
					.append($('<a>', {
						text: 'Удалить',
						'data-contactid': contact.id,
						click: function() {
							/*
							let _id = contact.id;
							let _name = contact.name;
						
							$("#editcontact_id").val(_id);
							$("#editcontact_name").val(_name);
							$('#modalDeleteContact').modal('show');
							*/
							if (confirm("Действительно удалить контакт?")) {
								$.post("/contact/delete", { id: contact.id }, function(data) {
									location.reload();
								});
							}
						}
					}))
				)
			);
			
			$('#contacts_table').append(_tr);
		}
	}

	// Очистить таблицу с контактами
	clearContactTable() {
		$('#contacts_table tr:not(:first)').remove();
	}
}


$(document).ready(function() {
	let app = new App();	
	console.log(app);

	$("#add_contact").click(function() {
		$('#modalAddContact').modal('show');
	});
	
	$("#search_contact").change(function() {
		app.hideContactsBySearchCondition($(this).val());
	});
	
	$("#reset_search").click(function() {
		$("#search_contact").val("");
		app.hideContactsBySearchCondition("");
	});
});