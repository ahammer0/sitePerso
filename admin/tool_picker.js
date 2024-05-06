pickerDiv=document.getElementById("tool_picker")
allTechnos=document.querySelector("div#tool_picker > input[name='all_technos']")
allTechnos=JSON.parse(allTechnos.value)
usedTechnos=document.querySelector("div#tool_picker > input[name='used_technos']")
usedTechnos=JSON.parse(usedTechnos.value)

const renderPicker = ()=>{
  pickerDiv.innerHTML=""

  allTechList=document.createElement("div")
  allTechList.classList.add("flex","flex-wrap","bg-primary")
  
  usedTechList=document.createElement("div")
  usedTechList.classList.add("flex","flex-wrap","bg-primary")

  const addTechno = (tech)=>{
    usedTechnos=[...usedTechnos,tech]
    renderPicker();
  }
  const rmTechno = (tech)=>{
    let index=usedTechnos.findIndex((elt)=>elt.name==tech.name)
    if(index>=0){
      usedTechnos.splice(index,1)
    }
    renderPicker()
  }

  for (let tech of allTechnos){
    techElt=document.createElement("div")
    
    techElt.addEventListener("click",()=>{addTechno(tech)})

    techEltImg=document.createElement("img")
    techEltImg.classList.add("sectionTools__img")
    techEltImg.src="../assets/icons/"+tech.picture
    techEltImg.height=40
    techEltImg.width=40

    techElt.appendChild(techEltImg)
    allTechList.appendChild(techElt)
  }
  for (let tech of usedTechnos){
    techElt=document.createElement("div")
    techElt.addEventListener("click",(e)=>{rmTechno(tech)})


    techEltImg=document.createElement("img")
    techEltImg.classList.add("sectionTools__img")
    techEltImg.src="../assets/icons/"+tech.picture
    techEltImg.height=40
    techEltImg.width=40

    techElt.appendChild(techEltImg)
    usedTechList.appendChild(techElt)
  }

  pickerDiv.appendChild(allTechList)
  pickerDiv.appendChild(usedTechList)
  usedTechInput=document.createElement("input")
  usedTechInput.type="hidden"
  usedTechInput.name="used_technos"
  usedTechInput.value=JSON.stringify(usedTechnos)

  pickerDiv.appendChild(usedTechInput)
}
renderPicker()
