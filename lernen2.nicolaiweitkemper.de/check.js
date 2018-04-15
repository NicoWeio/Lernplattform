function check(inputX, solutionX, settings) {
  var input = inputX; //wegen call-by-reference
  var solution = solutionX;

var errorType;
  
  if (solution == input) return {bool: true};
  if (input === "") return {bool: false, errorType: "keine Eingabe"};
  
  /*if (settings.spaces == "ignore") {
    if (trimAll(input) == solution) return true;
  }
  
  if (settings.brackets == "ignore") {
    if (removeBracketsWithContent(solution) == input) return true;
  }*/
  
  if(settings.customReplacements.length !== 0) {
    for(var key in settings.customReplacements) {
      input = input.replace(key, settings.customReplacements[key]);
      solution = solution.replace(key, settings.customReplacements[key]);
    }
  }
  
  if(settings.customReplacementsRegEx.length !== 0) {
    for(var key in settings.customReplacementsRegEx) {
      input = input.replace(new RegExp(key), settings.customReplacementsRegEx[key]);
      solution = solution.replace(new RegExp(key), settings.customReplacementsRegEx[key]);
    }
  }

  if(settings.periodAtEnd == "ignore") {
    if (input.charAt(input.length-1) == ".") input = input.slice(0,-1);
    if (solution.charAt(solution.length-1) == ".") solution = solution.slice(0,-1);
  }
  
  if (settings.case == "ignore") {
    input = input.toLowerCase();
    solution = solution.toLowerCase();
  }
  else if (input.toLowerCase() == solution.toLowerCase()) {
    errorType = "falsche Groß-/Kleinschreibung";
  }
  
  if (settings.specialChars == "ignore") {
    input = removeSpecialChars(input);
    solution = removeSpecialChars(solution);
  }
  else if (removeSpecialChars(input) == removeSpecialChars(solution)) {
    errorType = "falsche Sonderzeichen";
}
  
  if (settings.brackets == "ignore") {
    input = removeBracketsWithContent(input);
    solution = removeBracketsWithContent(solution);
  }
  else if (settings.brackets == "onlyIncorrect") {
    if (!(input.includes("(") && input.includes(")"))) {
      input = removeBracketsWithContent(input);
      solution = removeBracketsWithContent(solution);
    }
  }
  

  solution = trimAll(solution).trim();
  input = trimAll(input).trim();


  var output = [];

  output.bool = (solution == input);
  output.errorType = errorType;

  return output;
  
}

function removeBracketsWithContent(string) {
  
  while(string.includes("(") && string.includes(")")) {
    string = string.substring(0, string.indexOf("(")) + string.substring(string.indexOf(")")+1, string.length);
  }
  return string;
}

function trimAll(string) {
  return string.replace(/ +/g, " "); //https://stackoverflow.com/questions/3286874/remove-all-multiple-spaces-in-javascript-and-replace-with-single-space
}

function removeSpecialChars(string) { //setzt lowercase voraus
    var r=string.toLowerCase();
    r = r.replace(new RegExp(/\s/g),"");
    r = r.replace(new RegExp(/[àáâãäå]/g),"a");
    r = r.replace(new RegExp(/æ/g),"ae");
    r = r.replace(new RegExp(/ç/g),"c");
    r = r.replace(new RegExp(/[èéêë]/g),"e");
    r = r.replace(new RegExp(/[ìíîï]/g),"i");
    r = r.replace(new RegExp(/ñ/g),"n");                
    r = r.replace(new RegExp(/[òóôõö]/g),"o");
    r = r.replace(new RegExp(/œ/g),"oe");
    r = r.replace(new RegExp(/[ùúûü]/g),"u");
    r = r.replace(new RegExp(/[ýÿ]/g),"y");
    r = r.replace(new RegExp(/\W/g),"");
    return r;
}

//--------------------------------------

  function checkSimple(input, solution) {
    if (input == solution) return true;
    else return false;
  }
