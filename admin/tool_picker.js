pickerDiv=document.getElementById("tool_picker")
allTechnos=document.querySelector("div#tool_picker > input[name='all_technos']")
allTechnos=JSON.parse(allTechnos.value)
usedTechnos=document.querySelector("div#tool_picker > input[name='used_technos']")
usedTechnos=JSON.parse(usedTechnos.value)
picturePaths=document.querySelector("div#tool_picker > input[name='picture_paths']")
picturePaths=JSON.parse(picturePaths.value)
for (let tech of allTechnos){
  if (usedTechnos.find((elt)=>elt.name===tech.name)!==undefined){
    tech.isUsed=true
  }
  else{
    tech.isUsed=false
  }
}

const renderPicker = ()=>{
  pickerDiv.innerHTML=""

  availableTechList=document.createElement("div")
  availableTechList.classList.add("flex","flex-wrap","bg-light-gray","border")
  
  usedTechList=document.createElement("div")
  usedTechList.classList.add("flex","flex-wrap","bg-light-gray","border")

  const addTechno = (tech)=>{
    tech.isUsed=true
    renderPicker();
  }
  const rmTechno = (tech)=>{
    tech.isUsed=false
    renderPicker()
  }

  for (let tech of allTechnos){
    if(!tech.isUsed){
    techElt=document.createElement("div")
    
    techElt.addEventListener("click",()=>{addTechno(tech)})

    techEltImg=document.createElement("img")
    techEltImg.classList.add("sectionTools__img")
    techEltImg.src=picturePaths[tech.picture]
    techEltImg.height=40
    techEltImg.width=40

    techElt.appendChild(techEltImg)
    availableTechList.appendChild(techElt)
    }
  }
  for (let tech of allTechnos){
    if(tech.isUsed){
    techElt=document.createElement("div")
    techElt.addEventListener("click",(e)=>{rmTechno(tech)})


    techEltImg=document.createElement("img")
    techEltImg.classList.add("sectionTools__img")
    techEltImg.src=picturePaths[tech.picture]
    techEltImg.height=40
    techEltImg.width=40

    techElt.appendChild(techEltImg)
    usedTechList.appendChild(techElt)
    }
  }

  pickerDiv.appendChild(availableTechList)
  pickerDiv.appendChild(usedTechList)
  usedTechInput=document.createElement("input")
  usedTechInput.type="hidden"
  usedTechInput.name="used_technos"
  usedTechInput.value=JSON.stringify(usedTechnos)

  pickerDiv.appendChild(usedTechInput)
}
renderPicker()
