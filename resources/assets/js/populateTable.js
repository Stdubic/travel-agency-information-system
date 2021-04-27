// Get date stuff from moment
const currentTime = moment();
let month = moment(currentTime, 'YYYY-MM');

const PERIODS = [];

function handlePreviousMonth() {
	month = moment(month.subtract(1, 'months'), 'YYYY-MM');
	populateTable();
}

function handleNextMonth() {
	month = moment(month.add(1, 'months'), 'YYYY-MM');
	populateTable();
}

function updateTable() {
	let dateRange = document.getElementById('dateRange').value;
	let price = document.getElementById('price').value;
	let roomToSell = document.getElementById('roomsToSell').value;
	let minDays = document.getElementById('minDays').value;

	let dateRangeArray = dateRange.split(' - ');

	PERIODS.push({
		priceInHRK: price,
		startDate: moment(new Date(dateRangeArray[0])),
		endDate: moment(new Date(dateRangeArray[1])),
		numberOfRoomsToSell: roomToSell,
		minNumberOfDays: minDays
	});

	populateTable();

	fireNotification({
		message: 'Data updated successfully.',
		icon: 'fa fa-info',
		type: 'success',
		delay: 5
	});
}

function populateTable(items) {
	const range = momentWithRange().range(
		moment(month).startOf('month'),
		moment(month).endOf('month')
	);

	const days = Array.from(range.by('days'));

	// Get table references
	const monthsTableHeader = document.getElementById('months-names');
	const monthsTableData = document.getElementById('months-data');

	// Clear current data
	monthsTableHeader.innerHTML = '';
	monthsTableData.innerHTML = '';

	const currentYear = document.getElementById('year');
	const currentMonth = document.getElementById('month');
	currentYear.innerHTML = moment(month)
		.endOf('month')
		.format('YYYY');
	currentMonth.innerHTML = moment(month)
		.endOf('month')
		.format('MMMM');

	// Add table header
	const elements = days.map(day => '<th scope="col">' + day.format('DD dd') + '</th>');

	monthsTableHeader.innerHTML = '<tr>' + elements + '</tr>';
	monthsTableHeader.innerHTML = normalizeHtml(monthsTableHeader.innerHTML);

	items = items || PERIODS;

	// Return no content if no items
	if (!items) {
		monthsTableData.innerHTML = '<td colspan="12">There is no content</td>';
		return;
	}

	// Return elements
	let prices = [],
		rooms = [],
		minimumStays = [];

	days.forEach(date => {
		const itemFound = items.find(item => {
			const startDate = item.startDate.format('YYYY-MM-DD');
			const endDate = item.endDate.format('YYYY-MM-DD');
			const dateInMonth = date.format('YYYY-MM-DD');

			return dateInMonth >= startDate && dateInMonth <= endDate;
		});

		console.log(date.format('YYYY-MM-DD'));

		if (itemFound) {
			prices.push(
				'<td><input type="text" value="' +
					(itemFound.priceInHRK || '-') +
					'" style="width: 25px;"></td>'
			);
			rooms.push(
				'<td><input type="text" value="' +
					(itemFound.numberOfRoomsToSell || '-') +
					'" style="width: 25px;"></td>'
			);
			minimumStays.push(
				'<td><input type="text" value="' +
					(itemFound.minNumberOfDays || '-') +
					'" style="width: 25px;"></td>'
			);
			return;
		}

		prices.push('<td><input type="text" id="' + date.format('YYYY-MM-DD') + '_price' + '" name=price[' + date.format('YYYY-MM-DD') + ']" value="" style="width: 25px;"></td>');
		//prices.push('<td><input type="text" id="' + date.format('YYYY-MM-DD') + '_price' + '" name="' + date.format('YYYY-MM-DD') + '_price' + '" value="" style="width: 25px;"></td>');
		rooms.push('<td><input type="text" id="' + date.format('YYYY-MM-DD') + '_room' + '" name=room[' + date.format('YYYY-MM-DD') + ']" value="" style="width: 25px;"></td>');
		//rooms.push('<td><input type="text" id="' + date.format('YYYY-MM-DD') + '_room' + '" name="' + date.format('YYYY-MM-DD') + '_room' + '" value="" style="width: 25px;"></td>');
		minimumStays.push('<td><input type="text" id="' + date.format('YYYY-MM-DD') + '_stay' + '" name=stay[' + date.format('YYYY-MM-DD') + ']" value="" style="width: 25px;"></td>');
		//minimumStays.push('<td><input type="text" id="' + date.format('YYYY-MM-DD') + '_stay' + '" name="' + date.format('YYYY-MM-DD') + '_stay' + '" value="" style="width: 25px;"></td>');
	});

	// Render data
	monthsTableData.innerHTML += '<tr>' + prices.map(item => item) + '</tr>';
	monthsTableData.innerHTML += '<tr>' + rooms.map(item => item) + '</tr>';
	monthsTableData.innerHTML += '<tr>' + minimumStays.map(item => item) + '</tr>';
	monthsTableData.innerHTML = normalizeHtml(monthsTableData.innerHTML);
}

function normalizeHtml(html) {
	// Removes some strange ,,, chars from innerhtml
	return html.replace(/,+/gm, '');
}

function addPriceListRow() {
	const row = document.getElementById('pricelist-types-template').content.cloneNode(true);
	document.getElementById('pricelist-types-container').appendChild(row);

	initSelect();
	initSwitch();
}

function removePriceListRow(elem) {
	while (!elem.classList.contains('pricelist-types-item')) elem = elem.parentNode;
	elem.parentNode.removeChild(elem);
}

function gatherPriceListTypes() {
	const inputValues = [];
	const items = document.querySelectorAll('.pricelist-types-item');

	for (const item of items) {
		inputValues.push({
			price_type: item.querySelector('select.pricelist-types-item-price-type').value,
			service_type: item.querySelector('select.pricelist-types-item-service-type').value,
			percentage: item.querySelector('input.pricelist-types-item-percentage').value,
			active: item.querySelector('input.pricelist-types-item-active').checked
		});
	}

	return inputValues;
}

window.addEventListener('load', () => {
	document.querySelector('form.rate-form').onsubmit = () => {
		document.getElementById('pricelist-types-json').value = JSON.stringify(
			gatherPriceListTypes()
		);
	};
});
