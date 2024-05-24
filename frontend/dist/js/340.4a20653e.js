"use strict";(self["webpackChunkKPSM"]=self["webpackChunkKPSM"]||[]).push([[340],{55340:function(e,t,a){a.r(t),a.d(t,{default:function(){return Fe}});var r=a(56768),l=a(24232),s=a(45130);const d={class:"p-4 sm:ml-64 flex-grow overflow-y-auto"},n={class:"p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-14"},o=(0,r.Lk)("tr",{class:"text-center whitespace-nowrap"},[(0,r.Lk)("th",null,"Hor Code"),(0,r.Lk)("th",null,"Firstname"),(0,r.Lk)("th",null,"Middlename"),(0,r.Lk)("th",null,"Lastname"),(0,r.Lk)("th",null,"Age"),(0,r.Lk)("th",null,"Birthday"),(0,r.Lk)("th",null,"Gender"),(0,r.Lk)("th",null,"Province"),(0,r.Lk)("th",null,"Municipality"),(0,r.Lk)("th",null,"Barangay"),(0,r.Lk)("th",null,"Representative Fullname"),(0,r.Lk)("th",null,"Contact Number"),(0,r.Lk)("th",null,"Diagnosis"),(0,r.Lk)("th",null,"Hospital"),(0,r.Lk)("th",null,"Request"),(0,r.Lk)("th",null,"Status"),(0,r.Lk)("th",null,"Decline Reason"),(0,r.Lk)("th",null,"Amount"),(0,r.Lk)("th",null,"Check Requirements"),(0,r.Lk)("th",null,"Action")],-1),i={class:"h-[12vh] text-center"},c={class:"whitespace-nowrap uppercase"},u={class:"whitespace-nowrap uppercase"},m={class:"whitespace-nowrap uppercase"},h={class:"whitespace-nowrap uppercase"},p={class:"whitespace-nowrap uppercase"},g={class:"whitespace-nowrap uppercase"},b={class:"whitespace-nowrap uppercase"},k={class:"whitespace-nowrap uppercase"},v={class:"whitespace-nowrap uppercase"},w={class:"whitespace-nowrap uppercase"},f={class:"whitespace-nowrap uppercase"},x={class:"whitespace-nowrap uppercase"},y={class:"whitespace-nowrap uppercase"},L={class:"whitespace-nowrap uppercase"},_={class:"whitespace-nowrap uppercase"},R={class:"whitespace-nowrap uppercase"},q={class:"whitespace-nowrap uppercase"},M={class:"whitespace-nowrap uppercase"},I={style:{"margin-left":".8vw"},class:"whitespace-nowrap uppercase"},A=["onClick"],C={class:"whitespace-nowrap uppercase"},E=["onClick"],B=["onClick"],F={id:"declineModal",tabindex:"-1","aria-hidden":"true",class:"hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0"},j={class:"relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full"},D={class:"relative bg-white rounded-lg shadow dark:bg-gray-700"},S=(0,r.Fv)('<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"><h3 class="text-xl font-semibold text-gray-900 dark:text-white"> Decline Tupad Request </h3><button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="declineModal"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path></svg><span class="sr-only">Close modal</span></button></div>',1),P=(0,r.Lk)("label",{for:"Reason",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"Decline Reason",-1),X=(0,r.Lk)("input",{type:"text",id:"Reason","aria-describedby":"helper-text-explanation",class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",placeholder:"Reason here."},null,-1),$=(0,r.Lk)("div",{class:"flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600"},[(0,r.Lk)("button",{"data-modal-hide":"declineModal",type:"submit",class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"},"Approved")],-1),z=[P,X,$],T={id:"amountModal",tabindex:"-1","aria-hidden":"true",class:"hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0"},H={class:"relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full"},K={class:"relative bg-white rounded-lg shadow dark:bg-gray-700"},U=(0,r.Fv)('<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"><h3 class="text-xl font-semibold text-gray-900 dark:text-white"> Medical Assistance Amount </h3><button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="amountModal"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path></svg><span class="sr-only">Close modal</span></button></div>',1),V=(0,r.Lk)("label",{for:"Amount",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"Input Amount",-1),G=(0,r.Lk)("input",{type:"number",id:"AmountInput","aria-describedby":"helper-text-explanation",class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",placeholder:"eg. 1000"},null,-1),Q=(0,r.Lk)("div",{class:"flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600"},[(0,r.Lk)("button",{"data-modal-hide":"amountModal",type:"submit",class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"},"Approved")],-1),N=[V,G,Q],W={id:"RequirementsModal",tabindex:"-1","aria-hidden":"true",class:"hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0"},J={class:"relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full"},O={class:"relative bg-white rounded-lg shadow dark:bg-gray-700"},Y={class:"flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"},Z={class:"text-xl font-semibold text-gray-900 dark:text-white"},ee=(0,r.Lk)("button",{type:"button",class:"text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white","data-modal-hide":"RequirementsModal"},[(0,r.Lk)("svg",{class:"w-3 h-3","aria-hidden":"true",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 14 14"},[(0,r.Lk)("path",{stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"})]),(0,r.Lk)("span",{class:"sr-only"},"Close modal")],-1),te={class:"p-4"},ae={key:0},re=(0,r.Lk)("h4",{class:"text-lg font-semibold mb-2"},"Valid ID Image",-1),le=["src","alt","onClick"],se={key:1},de=(0,r.Lk)("h4",{class:"text-lg font-semibold mb-2"},"Hospital Documents Image",-1),ne=["src","alt","onClick"],oe={key:2},ie=(0,r.Lk)("h4",{class:"text-lg font-semibold mb-2"},"Barangay Clearance Image",-1),ce=["src","alt","onClick"],ue={id:"preview-modal",tabindex:"-1","aria-hidden":"true",class:"hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center"},me={class:"relative p-4 w-full max-w-2xl max-h-full"},he={class:"relative bg-white rounded-lg shadow dark:bg-gray-700"},pe={class:"flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"},ge=(0,r.Lk)("svg",{class:"w-3 h-3","aria-hidden":"true",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 14 14"},[(0,r.Lk)("path",{stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"})],-1),be=(0,r.Lk)("span",{class:"sr-only"},"Close modal",-1),ke=[ge,be],ve={class:"p-4 md:p-5 space-y-4"},we=["src"];function fe(e,t,a,P,X,$){const V=(0,r.g2)("Side"),G=(0,r.g2)("v-icon"),Q=(0,r.g2)("v-spacer"),ge=(0,r.g2)("v-text-field"),be=(0,r.g2)("v-card-title"),fe=(0,r.g2)("v-divider"),xe=(0,r.g2)("v-data-table"),ye=(0,r.g2)("v-card"),Le=(0,r.g2)("carousel");return(0,r.uX)(),(0,r.CE)(r.FK,null,[(0,r.bF)(V),(0,r.Lk)("div",null,[(0,r.Lk)("div",d,[(0,r.Lk)("div",n,[(0,r.bF)(ye,{flat:""},{default:(0,r.k6)((()=>[(0,r.bF)(be,{class:"d-flex align-center pe-2 bg-orange-200"},{default:(0,r.k6)((()=>[(0,r.bF)(G,{icon:"mdi-hospital-box-outline"}),(0,r.eW)("   Manage Medical Requests "),(0,r.bF)(Q),(0,r.bF)(ge,{modelValue:X.search,"onUpdate:modelValue":t[0]||(t[0]=e=>X.search=e),density:"compact",label:"Search","prepend-inner-icon":"mdi-magnify",variant:"solo-filled",flat:"","hide-details":"","single-line":""},null,8,["modelValue"])])),_:1}),(0,r.bF)(fe),(0,r.bF)(xe,{search:X.search,"onUpdate:search":t[1]||(t[1]=e=>X.search=e),items:X.items,"items-per-page":5},{headers:(0,r.k6)((({headers:e})=>[o])),item:(0,r.k6)((({item:e})=>[(0,r.Lk)("tr",i,[(0,r.Lk)("td",c,(0,l.v_)(e.Hor_code),1),(0,r.Lk)("td",u,(0,l.v_)(e.firstname),1),(0,r.Lk)("td",m,(0,l.v_)(e.middlename),1),(0,r.Lk)("td",h,(0,l.v_)(e.lastname),1),(0,r.Lk)("td",p,(0,l.v_)(e.age),1),(0,r.Lk)("td",g,(0,l.v_)(e.birthday),1),(0,r.Lk)("td",b,(0,l.v_)(e.gender),1),(0,r.Lk)("td",k,(0,l.v_)(e.province),1),(0,r.Lk)("td",v,(0,l.v_)(e.municipality),1),(0,r.Lk)("td",w,(0,l.v_)(e.barangay),1),(0,r.Lk)("td",f,(0,l.v_)(e.representativefullname),1),(0,r.Lk)("td",x,(0,l.v_)(e.contactnumber),1),(0,r.Lk)("td",y,(0,l.v_)(e.diagnosis),1),(0,r.Lk)("td",L,(0,l.v_)(e.hospital),1),(0,r.Lk)("td",_,(0,l.v_)(e.request),1),(0,r.Lk)("td",R,(0,l.v_)(e.status),1),(0,r.Lk)("td",q,(0,l.v_)(e.decline_reason||""),1),(0,r.Lk)("td",M,(0,l.v_)(e.amount?"₱"+parseFloat(e.amount).toFixed(2):""),1),(0,r.Lk)("td",I,[(0,r.Lk)("button",{onClick:t=>$.RequirementsModal(e.id),class:"block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm mt-1 px-2 py-2 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800",type:"button"}," Requiements ",8,A)]),(0,r.Lk)("td",C,[(0,r.bo)((0,r.Lk)("button",{onClick:t=>$.amountModal(e.id),class:"block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800",type:"button"}," Input Amount ",8,E),[[s.aG,!e.amount]]),(0,r.bo)((0,r.Lk)("button",{onClick:t=>$.DeclineModal(e.id),class:"block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-7 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800",type:"button"}," Decline ",8,B),[[s.aG,!e.amount]])])])])),_:1},8,["search","items"])])),_:1})])])]),(0,r.Lk)("div",F,[(0,r.Lk)("div",j,[(0,r.Lk)("div",D,[S,(0,r.Lk)("form",{onSubmit:t[2]||(t[2]=(0,s.D$)(((...e)=>$.DeclineRequest&&$.DeclineRequest(...e)),["prevent"])),class:"max-w-sm mx-auto mt-5 mb-5 ml-10"},z,32)])])]),(0,r.Lk)("div",T,[(0,r.Lk)("div",H,[(0,r.Lk)("div",K,[U,(0,r.Lk)("form",{onSubmit:t[3]||(t[3]=(0,s.D$)(((...e)=>$.updateAmount&&$.updateAmount(...e)),["prevent"])),class:"max-w-sm mx-auto mt-5 mb-5 ml-10"},N,32)])])]),(0,r.Lk)("div",W,[(0,r.Lk)("div",J,[(0,r.Lk)("div",O,[(0,r.Lk)("div",Y,[(0,r.Lk)("h3",Z,(0,l.v_)(X.medicalRequest.firstname)+" "+(0,l.v_)(X.medicalRequest.middlename)+" "+(0,l.v_)(X.medicalRequest.lastname)+" Requirements ",1),ee]),(0,r.Lk)("div",te,[X.medicalRequest.valid_id_imagepath&&X.medicalRequest.valid_id_imagepath.length?((0,r.uX)(),(0,r.CE)("div",ae,[re,(0,r.bF)(Le,{arrows:!0},{default:(0,r.k6)((()=>[((0,r.uX)(!0),(0,r.CE)(r.FK,null,(0,r.pI)(X.medicalRequest.valid_id_imagepath,((e,t)=>((0,r.uX)(),(0,r.CE)("div",{key:"valid_id_"+t},[(0,r.Lk)("img",{style:(0,l.Tr)(X.contentStyle),src:e,alt:"Valid ID Image "+(t+1),class:"w-full cursor-pointer mb-2",onClick:t=>$.previewImage(e)},null,12,le)])))),128))])),_:1})])):(0,r.Q3)("",!0),X.medicalRequest.hospital_document_imagepath&&X.medicalRequest.hospital_document_imagepath.length?((0,r.uX)(),(0,r.CE)("div",se,[de,(0,r.bF)(Le,{arrows:!0},{default:(0,r.k6)((()=>[((0,r.uX)(!0),(0,r.CE)(r.FK,null,(0,r.pI)(X.medicalRequest.hospital_document_imagepath,((e,t)=>((0,r.uX)(),(0,r.CE)("div",{key:"hospital_document_"+t},[(0,r.Lk)("img",{style:(0,l.Tr)(X.contentStyle),src:e,alt:"Hospital Documents Image "+(t+1),class:"w-full cursor-pointer mb-2",onClick:t=>$.previewImage(e)},null,12,ne)])))),128))])),_:1})])):(0,r.Q3)("",!0),X.medicalRequest.barangay_clearance_imagepath&&X.medicalRequest.barangay_clearance_imagepath.length?((0,r.uX)(),(0,r.CE)("div",oe,[ie,(0,r.bF)(Le,{arrows:!0},{default:(0,r.k6)((()=>[((0,r.uX)(!0),(0,r.CE)(r.FK,null,(0,r.pI)(X.medicalRequest.barangay_clearance_imagepath,((e,t)=>((0,r.uX)(),(0,r.CE)("div",{key:"barangay_clearance_"+t},[(0,r.Lk)("img",{style:(0,l.Tr)(X.contentStyle),src:e,alt:"Barangay Clearance Image "+(t+1),class:"w-full cursor-pointer mb-2",onClick:t=>$.previewImage(e)},null,12,ce)])))),128))])),_:1})])):(0,r.Q3)("",!0)])])])]),(0,r.Lk)("div",ue,[(0,r.Lk)("div",me,[(0,r.Lk)("div",he,[(0,r.Lk)("div",pe,[(0,r.Lk)("button",{"data-modal-hide":"preview-modal",onClick:t[4]||(t[4]=(...e)=>$.closePreviewModal&&$.closePreviewModal(...e)),type:"button",class:"text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"},ke)]),(0,r.Lk)("div",ve,[(0,r.Lk)("img",{src:X.previewedImage.url,class:"w-full h-auto",style:{"max-width":"100%","max-height":"80vh"}},null,8,we)])])])])],64)}var xe=a(29966),ye=a(48392),Le=a(91328),_e=a(88841),Re=a(39658),qe=a(5040),Me=a(55997),Ie=a(27411);const Ae=(0,Ie.dj)();var Ce={data(){return{imagePath:"",search:"",items:[],medicalRequest:[],contentStyle:{margin:0,height:"160px",color:"#fff",lineHeight:"160px",textAlign:"center",background:"#364d79"},previewedImage:{url:""}}},components:{Side:qe.A,Carousel:xe.A,ConfigProvider:ye.Ay,Popover:Le.A},mounted(){(0,_e.Tf)({Modal:_e.aF,Tooltip:_e.m_}),(0,Re.Tp)(),this.fetchMedicalRequests()},methods:{amountModal(e){this.itemId=e;const t=document.getElementById("amountModal");t.classList.remove("hidden"),t.setAttribute("aria-hidden","false"),t.addEventListener("click",(function(e){e.target&&e.target.closest('[data-modal-hide="amountModal"]')&&(t.classList.add("hidden"),t.setAttribute("aria-hidden","true"))}))},updateAmount(){const e=this.itemId,t=document.getElementById("AmountInput").value;Me.A.put(`/api/medical-requests/approve-amount/${e}`,{amount:t},{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then((e=>{Ae.success("Amount Approved"),this.fetchMedicalRequests()})).catch((e=>{console.error(e.response.data),Ae.error("Please input the amount value.")}))},previewImage(e){this.previewedImage.url=e,document.getElementById("RequirementsModal").classList.add("hidden"),document.getElementById("preview-modal").classList.remove("hidden"),document.getElementById("preview-modal").focus()},closePreviewModal(){document.getElementById("preview-modal").classList.add("hidden"),document.getElementById("RequirementsModal").classList.remove("hidden"),this.previewedImage.url=""},fetchMedicalRequests(){Me.A.get("/api/medical-requests/get-all",{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then((e=>{this.items=e.data})).catch((e=>{console.error("Error fetching medical requests:",e)}))},DeclineModal(e){this.itemId=e;const t=document.getElementById("declineModal");t.classList.remove("hidden"),t.setAttribute("aria-hidden","false"),t.addEventListener("click",(function(e){e.target&&e.target.closest('[data-modal-hide="declineModal"]')&&(t.classList.add("hidden"),t.setAttribute("aria-hidden","true"))}))},DeclineRequest(){const e=this.itemId,t=document.getElementById("Reason").value;Me.A.put(`/api/medical-requests/decline/${e}`,{decline_reason:t},{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then((e=>{Ae.success("Request Decline"),this.fetchMedicalRequests()})).catch((e=>{console.error(e.response.data)}))},RequirementsModal(e){Me.A.get(`/api/medical-requests/requirements-path/${e}`,{headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}).then((e=>{this.medicalRequest=e.data;const t=document.getElementById("RequirementsModal");t.classList.remove("hidden"),t.setAttribute("aria-hidden","false"),t.addEventListener("click",(function(e){e.target&&e.target.closest('[data-modal-hide="RequirementsModal"]')&&(t.classList.add("hidden"),t.setAttribute("aria-hidden","true"))})),this.medicalRequest.valid_id_imagepath=this.medicalRequest.valid_id_imagepath.map((e=>Me.A.defaults.baseURL+e)),this.medicalRequest.hospital_document_imagepath=this.medicalRequest.hospital_document_imagepath.map((e=>Me.A.defaults.baseURL+e)),this.medicalRequest.barangay_clearance_imagepath=this.medicalRequest.barangay_clearance_imagepath.map((e=>Me.A.defaults.baseURL+e))})).catch((e=>{console.error("Error fetching medical request data:",e)}))}}},Ee=a(71241);const Be=(0,Ee.A)(Ce,[["render",fe]]);var Fe=Be}}]);
//# sourceMappingURL=340.4a20653e.js.map