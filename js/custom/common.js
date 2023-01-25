
function Numberize(i) {
  $(document).on("keyup", i, function () {
    if (this.value.length > 0) {
      let n = parseInt(this.value.replace(/\D/g, ''), 10);
      $(this).val(n.toLocaleString());
    }
  });
}


function displayResponse(area = null, message, errorType = 'error') {

  let config = { timeOut: 8000 };

  switch (true) {
    case errorType == 'success':
      toastr.success(message, "", config);
      break;
    case errorType == 'warning':
      toastr.warning(message, "",  config);
      break;
    case errorType == 'error':
      toastr.error(message, "", config);
      break;
    default:
      toastr.warning(message, "", config);

  }
  // $(area).notify(message, {
  //     className: errorType,
  //     autoHide: true,
  //     clickToHide: true,
  //     autoHideDelay: 10000,
  // });
}

function Convert2Num(str) {
  let numStr;
  (str.length > 3)
    ? numStr = str.replace(/,/g, '').trim()
    : numStr = str;
  return parseFloat(numStr);
}

function formatString2Number(num) {
  let number = num.replace(/,/g, '').trim();
  let FormattedNumber = parseFloat(number).toLocaleString('us', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
  return FormattedNumber;
}


function FormatNum(number) {
  let FormattedNumber = parseFloat(number).toLocaleString('us', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
  return FormattedNumber;
}

function FormatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

function numberWithCommas(x) {
  let parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return parts.join(".");
}

function SanitizeString(str) {
  let newStr = str.replace(/,/g, '').trim();
  return newStr;
}