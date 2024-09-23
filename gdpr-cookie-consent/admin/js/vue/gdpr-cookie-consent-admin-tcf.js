(()=>{"use strict";class e extends Error{constructor(e){super(e),this.name="DecodingError"}}class t extends Error{constructor(e){super(e),this.name="EncodingError"}}class s extends Error{constructor(e){super(e),this.name="GVLError"}}class r extends Error{constructor(e,t,s=""){super(`invalid value ${t} passed for ${e} ${s}`),this.name="TCModelError"}}class n{static DICT="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_";static REVERSE_DICT=new Map([["A",0],["B",1],["C",2],["D",3],["E",4],["F",5],["G",6],["H",7],["I",8],["J",9],["K",10],["L",11],["M",12],["N",13],["O",14],["P",15],["Q",16],["R",17],["S",18],["T",19],["U",20],["V",21],["W",22],["X",23],["Y",24],["Z",25],["a",26],["b",27],["c",28],["d",29],["e",30],["f",31],["g",32],["h",33],["i",34],["j",35],["k",36],["l",37],["m",38],["n",39],["o",40],["p",41],["q",42],["r",43],["s",44],["t",45],["u",46],["v",47],["w",48],["x",49],["y",50],["z",51],["0",52],["1",53],["2",54],["3",55],["4",56],["5",57],["6",58],["7",59],["8",60],["9",61],["-",62],["_",63]]);static BASIS=6;static LCM=24;static encode(e){if(!/^[0-1]+$/.test(e))throw new t("Invalid bitField");const s=e.length%this.LCM;e+=s?"0".repeat(this.LCM-s):"";let r="";for(let t=0;t<e.length;t+=this.BASIS)r+=this.DICT[parseInt(e.substr(t,this.BASIS),2)];return r}static decode(t){if(!/^[A-Za-z0-9\-_]+$/.test(t))throw new e("Invalidly encoded Base64URL string");let s="";for(let e=0;e<t.length;e++){const r=this.REVERSE_DICT.get(t[e]).toString(2);s+="0".repeat(this.BASIS-r.length)+r}return s}}class i{static langSet=new Set(["AR","BG","BS","CA","CS","CY","DA","DE","EL","EN","ES","ET","EU","FI","FR","GL","HE","HR","HU","ID","IT","JA","KO","LT","LV","MK","MS","MT","NL","NO","PL","PT-BR","PT-PT","RO","RU","SK","SL","SR-LATN","SR-CYRL","SV","TL","TR","UK","ZH"]);has(e){return i.langSet.has(e)}parseLanguage(e){const t=(e=e.toUpperCase()).split("-")[0];if(e.length>=2&&2==t.length){if(i.langSet.has(e))return e;if(i.langSet.has(t))return t;const s=t+"-"+t;if(i.langSet.has(s))return s;for(const s of i.langSet)if(-1!==s.indexOf(e)||-1!==s.indexOf(t))return s}throw new Error(`unsupported language ${e}`)}forEach(e){i.langSet.forEach(e)}get size(){return i.langSet.size}}class o{static cmpId="cmpId";static cmpVersion="cmpVersion";static consentLanguage="consentLanguage";static consentScreen="consentScreen";static created="created";static supportOOB="supportOOB";static isServiceSpecific="isServiceSpecific";static lastUpdated="lastUpdated";static numCustomPurposes="numCustomPurposes";static policyVersion="policyVersion";static publisherCountryCode="publisherCountryCode";static publisherCustomConsents="publisherCustomConsents";static publisherCustomLegitimateInterests="publisherCustomLegitimateInterests";static publisherLegitimateInterests="publisherLegitimateInterests";static publisherConsents="publisherConsents";static publisherRestrictions="publisherRestrictions";static purposeConsents="purposeConsents";static purposeLegitimateInterests="purposeLegitimateInterests";static purposeOneTreatment="purposeOneTreatment";static specialFeatureOptins="specialFeatureOptins";static useNonStandardTexts="useNonStandardTexts";static vendorConsents="vendorConsents";static vendorLegitimateInterests="vendorLegitimateInterests";static vendorListVersion="vendorListVersion";static vendorsAllowed="vendorsAllowed";static vendorsDisclosed="vendorsDisclosed";static version="version"}class a{clone(){const e=new this.constructor;return Object.keys(this).forEach((t=>{const s=this.deepClone(this[t]);void 0!==s&&(e[t]=s)})),e}deepClone(e){const t=typeof e;if("number"===t||"string"===t||"boolean"===t)return e;if(null!==e&&"object"===t){if("function"==typeof e.clone)return e.clone();if(e instanceof Date)return new Date(e.getTime());if(void 0!==e[Symbol.iterator]){const t=[];for(const s of e)t.push(this.deepClone(s));return e instanceof Array?t:new e.constructor(t)}{const t={};for(const s in e)e.hasOwnProperty(s)&&(t[s]=this.deepClone(e[s]));return t}}}}var c,p,u,l;!function(e){e[e.NOT_ALLOWED=0]="NOT_ALLOWED",e[e.REQUIRE_CONSENT=1]="REQUIRE_CONSENT",e[e.REQUIRE_LI=2]="REQUIRE_LI"}(c||(c={}));class d extends a{static hashSeparator="-";purposeId_;restrictionType;constructor(e,t){super(),void 0!==e&&(this.purposeId=e),void 0!==t&&(this.restrictionType=t)}static unHash(e){const t=e.split(this.hashSeparator),s=new d;if(2!==t.length)throw new r("hash",e);return s.purposeId=parseInt(t[0],10),s.restrictionType=parseInt(t[1],10),s}get hash(){if(!this.isValid())throw new Error("cannot hash invalid PurposeRestriction");return`${this.purposeId}${d.hashSeparator}${this.restrictionType}`}get purposeId(){return this.purposeId_}set purposeId(e){this.purposeId_=e}isValid(){return Number.isInteger(this.purposeId)&&this.purposeId>0&&(this.restrictionType===c.NOT_ALLOWED||this.restrictionType===c.REQUIRE_CONSENT||this.restrictionType===c.REQUIRE_LI)}isSameAs(e){return this.purposeId===e.purposeId&&this.restrictionType===e.restrictionType}}class h extends a{bitLength=0;map=new Map;gvl_;has(e){return this.map.has(e)}isOkToHave(e,t,s){let r=!0;if(this.gvl?.vendors){const n=this.gvl.vendors[s];if(n)if(e===c.NOT_ALLOWED)r=n.legIntPurposes.includes(t)||n.purposes.includes(t);else if(n.flexiblePurposes.length)switch(e){case c.REQUIRE_CONSENT:r=n.flexiblePurposes.includes(t)&&n.legIntPurposes.includes(t);break;case c.REQUIRE_LI:r=n.flexiblePurposes.includes(t)&&n.purposes.includes(t)}else r=!1;else r=!1}return r}add(e,t){if(this.isOkToHave(t.restrictionType,t.purposeId,e)){const s=t.hash;this.has(s)||(this.map.set(s,new Set),this.bitLength=0),this.map.get(s).add(e)}}restrictPurposeToLegalBasis(e){const t=Array.from(this.gvl.vendorIds),s=e.hash,r=t[t.length-1],n=[...Array(r).keys()].map((e=>e+1));if(this.has(s))for(let e=1;e<=r;e++)this.map.get(s).add(e);else this.map.set(s,new Set(n)),this.bitLength=0}getVendors(e){let t=[];if(e){const s=e.hash;this.has(s)&&(t=Array.from(this.map.get(s)))}else{const e=new Set;this.map.forEach((t=>{t.forEach((t=>{e.add(t)}))})),t=Array.from(e)}return t.sort(((e,t)=>e-t))}getRestrictionType(e,t){let s;return this.getRestrictions(e).forEach((e=>{e.purposeId===t&&(void 0===s||s>e.restrictionType)&&(s=e.restrictionType)})),s}vendorHasRestriction(e,t){let s=!1;const r=this.getRestrictions(e);for(let e=0;e<r.length&&!s;e++)s=t.isSameAs(r[e]);return s}getMaxVendorId(){let e=0;return this.map.forEach((t=>{e=Math.max(Array.from(t)[t.size-1],e)})),e}getRestrictions(e){const t=[];return this.map.forEach(((s,r)=>{e?s.has(e)&&t.push(d.unHash(r)):t.push(d.unHash(r))})),t}getPurposes(){const e=new Set;return this.map.forEach(((t,s)=>{e.add(d.unHash(s).purposeId)})),Array.from(e)}remove(e,t){const s=t.hash,r=this.map.get(s);r&&(r.delete(e),0==r.size&&(this.map.delete(s),this.bitLength=0))}set gvl(e){this.gvl_||(this.gvl_=e,this.map.forEach(((e,t)=>{const s=d.unHash(t);Array.from(e).forEach((t=>{this.isOkToHave(s.restrictionType,s.purposeId,t)||e.delete(t)}))})))}get gvl(){return this.gvl_}isEmpty(){return 0===this.map.size}get numRestrictions(){return this.map.size}}!function(e){e.COOKIE="cookie",e.WEB="web",e.APP="app"}(p||(p={})),function(e){e.CORE="core",e.VENDORS_DISCLOSED="vendorsDisclosed",e.VENDORS_ALLOWED="vendorsAllowed",e.PUBLISHER_TC="publisherTC"}(u||(u={}));class g{static ID_TO_KEY=[u.CORE,u.VENDORS_DISCLOSED,u.VENDORS_ALLOWED,u.PUBLISHER_TC];static KEY_TO_ID={[u.CORE]:0,[u.VENDORS_DISCLOSED]:1,[u.VENDORS_ALLOWED]:2,[u.PUBLISHER_TC]:3}}class m extends a{bitLength=0;maxId_=0;set_=new Set;*[Symbol.iterator](){for(let e=1;e<=this.maxId;e++)yield[e,this.has(e)]}values(){return this.set_.values()}get maxId(){return this.maxId_}has(e){return this.set_.has(e)}unset(e){Array.isArray(e)?e.forEach((e=>this.unset(e))):"object"==typeof e?this.unset(Object.keys(e).map((e=>Number(e)))):(this.set_.delete(Number(e)),this.bitLength=0,e===this.maxId&&(this.maxId_=0,this.set_.forEach((e=>{this.maxId_=Math.max(this.maxId,e)}))))}isIntMap(e){let t="object"==typeof e;return t=t&&Object.keys(e).every((t=>{let s=Number.isInteger(parseInt(t,10));return s=s&&this.isValidNumber(e[t].id),s=s&&void 0!==e[t].name,s})),t}isValidNumber(e){return parseInt(e,10)>0}isSet(e){let t=!1;return e instanceof Set&&(t=Array.from(e).every(this.isValidNumber)),t}set(e){if(Array.isArray(e))e.forEach((e=>this.set(e)));else if(this.isSet(e))this.set(Array.from(e));else if(this.isIntMap(e))this.set(Object.keys(e).map((e=>Number(e))));else{if(!this.isValidNumber(e))throw new r("set()",e,"must be positive integer array, positive integer, Set<number>, or IntMap");this.set_.add(e),this.maxId_=Math.max(this.maxId,e),this.bitLength=0}}empty(){this.set_=new Set}forEach(e){for(let t=1;t<=this.maxId;t++)e(this.has(t),t)}get size(){return this.set_.size}setAll(e){this.set(e)}}class f{static[o.cmpId]=12;static[o.cmpVersion]=12;static[o.consentLanguage]=12;static[o.consentScreen]=6;static[o.created]=36;static[o.isServiceSpecific]=1;static[o.lastUpdated]=36;static[o.policyVersion]=6;static[o.publisherCountryCode]=12;static[o.publisherLegitimateInterests]=24;static[o.publisherConsents]=24;static[o.purposeConsents]=24;static[o.purposeLegitimateInterests]=24;static[o.purposeOneTreatment]=1;static[o.specialFeatureOptins]=12;static[o.useNonStandardTexts]=1;static[o.vendorListVersion]=12;static[o.version]=6;static anyBoolean=1;static encodingType=1;static maxId=16;static numCustomPurposes=6;static numEntries=12;static numRestrictions=12;static purposeId=6;static restrictionType=2;static segmentType=3;static singleOrRange=1;static vendorId=16}class v{static encode(e,s){let r;if("string"==typeof e&&(e=parseInt(e,10)),r=e.toString(2),r.length>s||e<0)throw new t(`${e} too large to encode into ${s}`);return r.length<s&&(r="0".repeat(s-r.length)+r),r}static decode(t,s){if(s!==t.length)throw new e("invalid bit length");return parseInt(t,2)}}class C{static encode(e,t){return v.encode(Math.round(e.getTime()/100),t)}static decode(t,s){if(s!==t.length)throw new e("invalid bit length");const r=new Date;return r.setTime(100*v.decode(t,s)),r}}class E{static encode(e){return String(Number(e))}static decode(e){return"1"===e}}class y{static encode(e,t){let s="";for(let r=1;r<=t;r++)s+=E.encode(e.has(r));return s}static decode(t,s){if(t.length!==s)throw new e("bitfield encoding length mismatch");const r=new m;for(let e=1;e<=s;e++)E.decode(t[e-1])&&r.set(e);return r.bitLength=t.length,r}}class I{static encode(e,s){const r=(e=e.toUpperCase()).charCodeAt(0)-65,n=e.charCodeAt(1)-65;if(r<0||r>25||n<0||n>25)throw new t(`invalid language code: ${e}`);if(s%2==1)throw new t(`numBits must be even, ${s} is not valid`);return s/=2,v.encode(r,s)+v.encode(n,s)}static decode(t,s){let r;if(s!==t.length||t.length%2)throw new e("invalid bit length for language");{const e=65,s=t.length/2,n=v.decode(t.slice(0,s),s)+e,i=v.decode(t.slice(s),s)+e;r=String.fromCharCode(n)+String.fromCharCode(i)}return r}}class L{static encode(e){let t=v.encode(e.numRestrictions,f.numRestrictions);if(!e.isEmpty()){const s=(t,s)=>{for(let r=t+1;r<=s;r++)if(e.gvl.vendorIds.has(r))return r;return t};e.getRestrictions().forEach((r=>{t+=v.encode(r.purposeId,f.purposeId),t+=v.encode(r.restrictionType,f.restrictionType);const n=e.getVendors(r),i=n.length;let o=0,a=0,c="";for(let e=0;e<i;e++){const t=n[e];if(0===a&&(o++,a=t),e===i-1||n[e+1]>s(t,n[i-1])){const e=!(t===a);c+=E.encode(e),c+=v.encode(a,f.vendorId),e&&(c+=v.encode(t,f.vendorId)),a=0}}t+=v.encode(o,f.numEntries),t+=c}))}return t}static decode(t){let s=0;const r=new h,n=v.decode(t.substr(s,f.numRestrictions),f.numRestrictions);s+=f.numRestrictions;for(let i=0;i<n;i++){const n=v.decode(t.substr(s,f.purposeId),f.purposeId);s+=f.purposeId;const i=v.decode(t.substr(s,f.restrictionType),f.restrictionType);s+=f.restrictionType;const o=new d(n,i),a=v.decode(t.substr(s,f.numEntries),f.numEntries);s+=f.numEntries;for(let n=0;n<a;n++){const n=E.decode(t.substr(s,f.anyBoolean));s+=f.anyBoolean;const i=v.decode(t.substr(s,f.vendorId),f.vendorId);if(s+=f.vendorId,n){const n=v.decode(t.substr(s,f.vendorId),f.vendorId);if(s+=f.vendorId,n<i)throw new e(`Invalid RangeEntry: endVendorId ${n} is less than ${i}`);for(let e=i;e<=n;e++)r.add(e,o)}else r.add(i,o)}}return r.bitLength=s,r}}!function(e){e[e.FIELD=0]="FIELD",e[e.RANGE=1]="RANGE"}(l||(l={}));class S{static encode(e){const t=[];let s,r=[],n=v.encode(e.maxId,f.maxId),i="";const o=f.maxId+f.encodingType,a=o+e.maxId,c=2*f.vendorId+f.singleOrRange+f.numEntries;let p=o+f.numEntries;return e.forEach(((n,o)=>{i+=E.encode(n),s=e.maxId>c&&p<a,s&&n&&(e.has(o+1)?0===r.length&&(r.push(o),p+=f.singleOrRange,p+=f.vendorId):(r.push(o),p+=f.vendorId,t.push(r),r=[]))})),s?(n+=String(l.RANGE),n+=this.buildRangeEncoding(t)):(n+=String(l.FIELD),n+=i),n}static decode(t,s){let r,n=0;const i=v.decode(t.substr(n,f.maxId),f.maxId);n+=f.maxId;const o=v.decode(t.charAt(n),f.encodingType);if(n+=f.encodingType,o===l.RANGE){if(r=new m,1===s){if("1"===t.substr(n,1))throw new e("Unable to decode default consent=1");n++}const i=v.decode(t.substr(n,f.numEntries),f.numEntries);n+=f.numEntries;for(let e=0;e<i;e++){const e=E.decode(t.charAt(n));n+=f.singleOrRange;const s=v.decode(t.substr(n,f.vendorId),f.vendorId);if(n+=f.vendorId,e){const e=v.decode(t.substr(n,f.vendorId),f.vendorId);n+=f.vendorId;for(let t=s;t<=e;t++)r.set(t)}else r.set(s)}}else{const e=t.substr(n,i);n+=i,r=y.decode(e,i)}return r.bitLength=n,r}static buildRangeEncoding(e){const t=e.length;let s=v.encode(t,f.numEntries);return e.forEach((e=>{const t=1===e.length;s+=E.encode(!t),s+=v.encode(e[0],f.vendorId),t||(s+=v.encode(e[1],f.vendorId))})),s}}function b(){return{[o.version]:v,[o.created]:C,[o.lastUpdated]:C,[o.cmpId]:v,[o.cmpVersion]:v,[o.consentScreen]:v,[o.consentLanguage]:I,[o.vendorListVersion]:v,[o.policyVersion]:v,[o.isServiceSpecific]:E,[o.useNonStandardTexts]:E,[o.specialFeatureOptins]:y,[o.purposeConsents]:y,[o.purposeLegitimateInterests]:y,[o.purposeOneTreatment]:E,[o.publisherCountryCode]:I,[o.vendorConsents]:S,[o.vendorLegitimateInterests]:S,[o.publisherRestrictions]:L,segmentType:v,[o.vendorsDisclosed]:S,[o.vendorsAllowed]:S,[o.publisherConsents]:y,[o.publisherLegitimateInterests]:y,[o.numCustomPurposes]:v,[o.publisherCustomConsents]:y,[o.publisherCustomLegitimateInterests]:y}}class A{1={[u.CORE]:[o.version,o.created,o.lastUpdated,o.cmpId,o.cmpVersion,o.consentScreen,o.consentLanguage,o.vendorListVersion,o.purposeConsents,o.vendorConsents]};2={[u.CORE]:[o.version,o.created,o.lastUpdated,o.cmpId,o.cmpVersion,o.consentScreen,o.consentLanguage,o.vendorListVersion,o.policyVersion,o.isServiceSpecific,o.useNonStandardTexts,o.specialFeatureOptins,o.purposeConsents,o.purposeLegitimateInterests,o.purposeOneTreatment,o.publisherCountryCode,o.vendorConsents,o.vendorLegitimateInterests,o.publisherRestrictions],[u.PUBLISHER_TC]:[o.publisherConsents,o.publisherLegitimateInterests,o.numCustomPurposes,o.publisherCustomConsents,o.publisherCustomLegitimateInterests],[u.VENDORS_ALLOWED]:[o.vendorsAllowed],[u.VENDORS_DISCLOSED]:[o.vendorsDisclosed]}}class V{1=[u.CORE];2=[u.CORE];constructor(e,t){if(2===e.version)if(e.isServiceSpecific)this[2].push(u.PUBLISHER_TC);else{const s=!(!t||!t.isForVendors);s&&!0!==e[o.supportOOB]||this[2].push(u.VENDORS_DISCLOSED),s&&(e[o.supportOOB]&&e[o.vendorsAllowed].size>0&&this[2].push(u.VENDORS_ALLOWED),this[2].push(u.PUBLISHER_TC))}}}class w{static fieldSequence=new A;static encode(e,s){let r;try{r=this.fieldSequence[String(e.version)][s]}catch(r){throw new t(`Unable to encode version: ${e.version}, segment: ${s}`)}let i="";s!==u.CORE&&(i=v.encode(g.KEY_TO_ID[s],f.segmentType));const a=b();return r.forEach((r=>{const n=e[r],c=a[r];let p=f[r];void 0===p&&this.isPublisherCustom(r)&&(p=Number(e[o.numCustomPurposes]));try{i+=c.encode(n,p)}catch(e){throw new t(`Error encoding ${s}->${r}: ${e.message}`)}})),n.encode(i)}static decode(t,s,r){const i=n.decode(t);let a=0;r===u.CORE&&(s.version=v.decode(i.substr(a,f[o.version]),f[o.version])),r!==u.CORE&&(a+=f.segmentType);const c=this.fieldSequence[String(s.version)][r],p=b();return c.forEach((t=>{const r=p[t];let n=f[t];if(void 0===n&&this.isPublisherCustom(t)&&(n=Number(s[o.numCustomPurposes])),0!==n){const o=i.substr(a,n);if(s[t]=r===S?r.decode(o,s.version):r.decode(o,n),Number.isInteger(n))a+=n;else{if(!Number.isInteger(s[t].bitLength))throw new e(t);a+=s[t].bitLength}}})),s}static isPublisherCustom(e){return 0===e.indexOf("publisherCustom")}}class _{static processor=[e=>e,(e,t)=>{e.publisherRestrictions.gvl=t,e.purposeLegitimateInterests.unset([1,3,4,5,6]);const s=new Map;return s.set("legIntPurposes",e.vendorLegitimateInterests),s.set("purposes",e.vendorConsents),s.forEach(((s,r)=>{s.forEach(((n,i)=>{if(n){const n=t.vendors[i];if(!n||n.deletedDate)s.unset(i);else if(0===n[r].length)if("legIntPurposes"===r&&0===n.purposes.length&&0===n.legIntPurposes.length&&n.specialPurposes.length>0);else if(e.isServiceSpecific)if(0===n.flexiblePurposes.length)s.unset(i);else{const t=e.publisherRestrictions.getRestrictions(i);let n=!1;for(let e=0,s=t.length;e<s&&!n;e++)n=t[e].restrictionType===c.REQUIRE_CONSENT&&"purposes"===r||t[e].restrictionType===c.REQUIRE_LI&&"legIntPurposes"===r;n||s.unset(i)}else s.unset(i)}}))})),e.vendorsDisclosed.set(t.vendors),e}];static process(e,s){const r=e.gvl;if(!r)throw new t("Unable to encode TCModel without a GVL");if(!r.isReady)throw new t("Unable to encode TCModel tcModel.gvl.readyPromise is not resolved");(e=e.clone()).consentLanguage=r.language.slice(0,2).toUpperCase(),s?.version>0&&s?.version<=this.processor.length?e.version=s.version:e.version=this.processor.length;const n=e.version-1;if(!this.processor[n])throw new t(`Invalid version: ${e.version}`);return this.processor[n](e,r)}}class O{static absCall(e,t,s,r){return new Promise(((n,i)=>{const o=new XMLHttpRequest;o.withCredentials=s,o.addEventListener("load",(()=>{if(o.readyState==XMLHttpRequest.DONE)if(o.status>=200&&o.status<300){let e=o.response;if("string"==typeof e)try{e=JSON.parse(e)}catch(e){}n(e)}else i(new Error(`HTTP Status: ${o.status} response type: ${o.responseType}`))})),o.addEventListener("error",(()=>{i(new Error("error"))})),o.addEventListener("abort",(()=>{i(new Error("aborted"))})),null===t?o.open("GET",e,!0):o.open("POST",e,!0),o.responseType="json",o.timeout=r,o.ontimeout=()=>{i(new Error("Timeout "+r+"ms "+e))},o.send(t)}))}static post(e,t,s=!1,r=0){return this.absCall(e,JSON.stringify(t),s,r)}static fetch(e,t=!1,s=0){return this.absCall(e,null,t,s)}}class P extends a{static LANGUAGE_CACHE=new Map;static CACHE=new Map;static LATEST_CACHE_KEY=0;static DEFAULT_LANGUAGE="EN";static consentLanguages=new i;static baseUrl_;static set baseUrl(e){if(/^https?:\/\/vendorlist\.consensu\.org\//.test(e))throw new s("Invalid baseUrl!  You may not pull directly from vendorlist.consensu.org and must provide your own cache");e.length>0&&"/"!==e[e.length-1]&&(e+="/"),this.baseUrl_=e}static get baseUrl(){return this.baseUrl_}static latestFilename="vendor-list.json";static versionedFilename="archives/vendor-list-v[VERSION].json";static languageFilename="purposes-[LANG].json";readyPromise;gvlSpecificationVersion;vendorListVersion;tcfPolicyVersion;lastUpdated;purposes;specialPurposes;features;specialFeatures;isReady_=!1;vendors_;vendorIds;fullVendorList;byPurposeVendorMap;bySpecialPurposeVendorMap;byFeatureVendorMap;bySpecialFeatureVendorMap;stacks;dataCategories;lang_;cacheLang_;isLatest=!1;constructor(e,t){super();let r=P.baseUrl,n=t?.language;if(n)try{n=P.consentLanguages.parseLanguage(n)}catch(e){throw new s("Error during parsing the language: "+e.message)}if(this.lang_=n||P.DEFAULT_LANGUAGE,this.cacheLang_=n||P.DEFAULT_LANGUAGE,this.isVendorList(e))this.populate(e),this.readyPromise=Promise.resolve();else{if(!r)throw new s("must specify GVL.baseUrl before loading GVL json");if(e>0){const t=e;P.CACHE.has(t)?(this.populate(P.CACHE.get(t)),this.readyPromise=Promise.resolve()):(r+=P.versionedFilename.replace("[VERSION]",String(t)),this.readyPromise=this.fetchJson(r))}else P.CACHE.has(P.LATEST_CACHE_KEY)?(this.populate(P.CACHE.get(P.LATEST_CACHE_KEY)),this.readyPromise=Promise.resolve()):(this.isLatest=!0,this.readyPromise=this.fetchJson(r+P.latestFilename))}}static emptyLanguageCache(e){let t=!1;return null==e&&P.LANGUAGE_CACHE.size>0?(P.LANGUAGE_CACHE=new Map,t=!0):"string"==typeof e&&this.consentLanguages.has(e.toUpperCase())&&(P.LANGUAGE_CACHE.delete(e.toUpperCase()),t=!0),t}static emptyCache(e){let t=!1;return Number.isInteger(e)&&e>=0?(P.CACHE.delete(e),t=!0):void 0===e&&(P.CACHE=new Map,t=!0),t}cacheLanguage(){P.LANGUAGE_CACHE.has(this.cacheLang_)||P.LANGUAGE_CACHE.set(this.cacheLang_,{purposes:this.purposes,specialPurposes:this.specialPurposes,features:this.features,specialFeatures:this.specialFeatures,stacks:this.stacks,dataCategories:this.dataCategories})}async fetchJson(e){try{this.populate(await O.fetch(e))}catch(e){throw new s(e.message)}}getJson(){return{gvlSpecificationVersion:this.gvlSpecificationVersion,vendorListVersion:this.vendorListVersion,tcfPolicyVersion:this.tcfPolicyVersion,lastUpdated:this.lastUpdated,purposes:this.clonePurposes(),specialPurposes:this.cloneSpecialPurposes(),features:this.cloneFeatures(),specialFeatures:this.cloneSpecialFeatures(),stacks:this.cloneStacks(),...this.dataCategories?{dataCategories:this.cloneDataCategories()}:{},vendors:this.cloneVendors()}}cloneSpecialFeatures(){const e={};for(const t of Object.keys(this.specialFeatures))e[t]=P.cloneFeature(this.specialFeatures[t]);return e}cloneFeatures(){const e={};for(const t of Object.keys(this.features))e[t]=P.cloneFeature(this.features[t]);return e}cloneStacks(){const e={};for(const t of Object.keys(this.stacks))e[t]=P.cloneStack(this.stacks[t]);return e}cloneDataCategories(){const e={};for(const t of Object.keys(this.dataCategories))e[t]=P.cloneDataCategory(this.dataCategories[t]);return e}cloneSpecialPurposes(){const e={};for(const t of Object.keys(this.specialPurposes))e[t]=P.clonePurpose(this.specialPurposes[t]);return e}clonePurposes(){const e={};for(const t of Object.keys(this.purposes))e[t]=P.clonePurpose(this.purposes[t]);return e}static clonePurpose(e){return{id:e.id,name:e.name,description:e.description,...e.descriptionLegal?{descriptionLegal:e.descriptionLegal}:{},...e.illustrations?{illustrations:Array.from(e.illustrations)}:{}}}static cloneFeature(e){return{id:e.id,name:e.name,description:e.description,...e.descriptionLegal?{descriptionLegal:e.descriptionLegal}:{},...e.illustrations?{illustrations:Array.from(e.illustrations)}:{}}}static cloneDataCategory(e){return{id:e.id,name:e.name,description:e.description}}static cloneStack(e){return{id:e.id,name:e.name,description:e.description,purposes:Array.from(e.purposes),specialFeatures:Array.from(e.specialFeatures)}}static cloneDataRetention(e){return{..."number"==typeof e.stdRetention?{stdRetention:e.stdRetention}:{},purposes:{...e.purposes},specialPurposes:{...e.specialPurposes}}}static cloneVendorUrls(e){return e.map((e=>({langId:e.langId,privacy:e.privacy,...e.legIntClaim?{legIntClaim:e.legIntClaim}:{}})))}static cloneVendor(e){return{id:e.id,name:e.name,purposes:Array.from(e.purposes),legIntPurposes:Array.from(e.legIntPurposes),flexiblePurposes:Array.from(e.flexiblePurposes),specialPurposes:Array.from(e.specialPurposes),features:Array.from(e.features),specialFeatures:Array.from(e.specialFeatures),...e.overflow?{overflow:{httpGetLimit:e.overflow.httpGetLimit}}:{},..."number"==typeof e.cookieMaxAgeSeconds||null===e.cookieMaxAgeSeconds?{cookieMaxAgeSeconds:e.cookieMaxAgeSeconds}:{},...void 0!==e.usesCookies?{usesCookies:e.usesCookies}:{},...e.policyUrl?{policyUrl:e.policyUrl}:{},...void 0!==e.cookieRefresh?{cookieRefresh:e.cookieRefresh}:{},...void 0!==e.usesNonCookieAccess?{usesNonCookieAccess:e.usesNonCookieAccess}:{},...e.dataRetention?{dataRetention:this.cloneDataRetention(e.dataRetention)}:{},...e.urls?{urls:this.cloneVendorUrls(e.urls)}:{},...e.dataDeclaration?{dataDeclaration:Array.from(e.dataDeclaration)}:{},...e.deviceStorageDisclosureUrl?{deviceStorageDisclosureUrl:e.deviceStorageDisclosureUrl}:{},...e.deletedDate?{deletedDate:e.deletedDate}:{}}}cloneVendors(){const e={};for(const t of Object.keys(this.fullVendorList))e[t]=P.cloneVendor(this.fullVendorList[t]);return e}async changeLanguage(e){let t=e;try{t=P.consentLanguages.parseLanguage(e)}catch(e){throw new s("Error during parsing the language: "+e.message)}const r=e.toUpperCase();if((t.toLowerCase()!==P.DEFAULT_LANGUAGE.toLowerCase()||P.LANGUAGE_CACHE.has(r))&&t!==this.lang_)if(this.lang_=t,P.LANGUAGE_CACHE.has(r)){const e=P.LANGUAGE_CACHE.get(r);for(const t in e)e.hasOwnProperty(t)&&(this[t]=e[t])}else{const e=P.baseUrl+P.languageFilename.replace("[LANG]",this.lang_.toLowerCase());try{await this.fetchJson(e),this.cacheLang_=r,this.cacheLanguage()}catch(e){throw new s("unable to load language: "+e.message)}}}get language(){return this.lang_}isVendorList(e){return void 0!==e&&void 0!==e.vendors}populate(e){this.purposes=e.purposes,this.specialPurposes=e.specialPurposes,this.features=e.features,this.specialFeatures=e.specialFeatures,this.stacks=e.stacks,this.dataCategories=e.dataCategories,this.isVendorList(e)&&(this.gvlSpecificationVersion=e.gvlSpecificationVersion,this.tcfPolicyVersion=e.tcfPolicyVersion,this.vendorListVersion=e.vendorListVersion,this.lastUpdated=e.lastUpdated,"string"==typeof this.lastUpdated&&(this.lastUpdated=new Date(this.lastUpdated)),this.vendors_=e.vendors,this.fullVendorList=e.vendors,this.mapVendors(),this.isReady_=!0,this.isLatest&&P.CACHE.set(P.LATEST_CACHE_KEY,this.getJson()),P.CACHE.has(this.vendorListVersion)||P.CACHE.set(this.vendorListVersion,this.getJson())),this.cacheLanguage()}mapVendors(e){this.byPurposeVendorMap={},this.bySpecialPurposeVendorMap={},this.byFeatureVendorMap={},this.bySpecialFeatureVendorMap={},Object.keys(this.purposes).forEach((e=>{this.byPurposeVendorMap[e]={legInt:new Set,consent:new Set,flexible:new Set}})),Object.keys(this.specialPurposes).forEach((e=>{this.bySpecialPurposeVendorMap[e]=new Set})),Object.keys(this.features).forEach((e=>{this.byFeatureVendorMap[e]=new Set})),Object.keys(this.specialFeatures).forEach((e=>{this.bySpecialFeatureVendorMap[e]=new Set})),Array.isArray(e)||(e=Object.keys(this.fullVendorList).map((e=>+e))),this.vendorIds=new Set(e),this.vendors_=e.reduce(((e,t)=>{const s=this.vendors_[String(t)];return s&&void 0===s.deletedDate&&(s.purposes.forEach((e=>{this.byPurposeVendorMap[String(e)].consent.add(t)})),s.specialPurposes.forEach((e=>{this.bySpecialPurposeVendorMap[String(e)].add(t)})),s.legIntPurposes.forEach((e=>{this.byPurposeVendorMap[String(e)].legInt.add(t)})),s.flexiblePurposes&&s.flexiblePurposes.forEach((e=>{this.byPurposeVendorMap[String(e)].flexible.add(t)})),s.features.forEach((e=>{this.byFeatureVendorMap[String(e)].add(t)})),s.specialFeatures.forEach((e=>{this.bySpecialFeatureVendorMap[String(e)].add(t)})),e[t]=s),e}),{})}getFilteredVendors(e,t,s,r){const n=e.charAt(0).toUpperCase()+e.slice(1);let i;const o={};return i="purpose"===e&&s?this["by"+n+"VendorMap"][String(t)][s]:this["by"+(r?"Special":"")+n+"VendorMap"][String(t)],i.forEach((e=>{o[String(e)]=this.vendors[String(e)]})),o}getVendorsWithConsentPurpose(e){return this.getFilteredVendors("purpose",e,"consent")}getVendorsWithLegIntPurpose(e){return this.getFilteredVendors("purpose",e,"legInt")}getVendorsWithFlexiblePurpose(e){return this.getFilteredVendors("purpose",e,"flexible")}getVendorsWithSpecialPurpose(e){return this.getFilteredVendors("purpose",e,void 0,!0)}getVendorsWithFeature(e){return this.getFilteredVendors("feature",e)}getVendorsWithSpecialFeature(e){return this.getFilteredVendors("feature",e,void 0,!0)}get vendors(){return this.vendors_}narrowVendorsTo(e){this.mapVendors(e)}get isReady(){return this.isReady_}clone(){const e=new P(this.getJson());return this.lang_!==P.DEFAULT_LANGUAGE&&e.changeLanguage(this.lang_),e}static isInstanceOf(e){return"object"==typeof e&&"function"==typeof e.narrowVendorsTo}}class T extends a{static consentLanguages=P.consentLanguages;isServiceSpecific_=!1;supportOOB_=!0;useNonStandardTexts_=!1;purposeOneTreatment_=!1;publisherCountryCode_="AA";version_=2;consentScreen_=0;policyVersion_=4;consentLanguage_="EN";cmpId_=0;cmpVersion_=0;vendorListVersion_=0;numCustomPurposes_=0;gvl_;created;lastUpdated;specialFeatureOptins=new m;purposeConsents=new m;purposeLegitimateInterests=new m;publisherConsents=new m;publisherLegitimateInterests=new m;publisherCustomConsents=new m;publisherCustomLegitimateInterests=new m;customPurposes;vendorConsents=new m;vendorLegitimateInterests=new m;vendorsDisclosed=new m;vendorsAllowed=new m;publisherRestrictions=new h;constructor(e){super(),e&&(this.gvl=e),this.updated()}set gvl(e){P.isInstanceOf(e)||(e=new P(e)),this.gvl_=e,this.publisherRestrictions.gvl=e}get gvl(){return this.gvl_}set cmpId(e){if(e=Number(e),!(Number.isInteger(e)&&e>1))throw new r("cmpId",e);this.cmpId_=e}get cmpId(){return this.cmpId_}set cmpVersion(e){if(e=Number(e),!(Number.isInteger(e)&&e>-1))throw new r("cmpVersion",e);this.cmpVersion_=e}get cmpVersion(){return this.cmpVersion_}set consentScreen(e){if(e=Number(e),!(Number.isInteger(e)&&e>-1))throw new r("consentScreen",e);this.consentScreen_=e}get consentScreen(){return this.consentScreen_}set consentLanguage(e){this.consentLanguage_=e}get consentLanguage(){return this.consentLanguage_}set publisherCountryCode(e){if(!/^([A-z]){2}$/.test(e))throw new r("publisherCountryCode",e);this.publisherCountryCode_=e.toUpperCase()}get publisherCountryCode(){return this.publisherCountryCode_}set vendorListVersion(e){if((e=0|Number(e))<0)throw new r("vendorListVersion",e);this.vendorListVersion_=e}get vendorListVersion(){return this.gvl?this.gvl.vendorListVersion:this.vendorListVersion_}set policyVersion(e){if(this.policyVersion_=parseInt(e,10),this.policyVersion_<0)throw new r("policyVersion",e)}get policyVersion(){return this.gvl?this.gvl.tcfPolicyVersion:this.policyVersion_}set version(e){this.version_=parseInt(e,10)}get version(){return this.version_}set isServiceSpecific(e){this.isServiceSpecific_=e}get isServiceSpecific(){return this.isServiceSpecific_}set useNonStandardTexts(e){this.useNonStandardTexts_=e}get useNonStandardTexts(){return this.useNonStandardTexts_}set supportOOB(e){this.supportOOB_=e}get supportOOB(){return this.supportOOB_}set purposeOneTreatment(e){this.purposeOneTreatment_=e}get purposeOneTreatment(){return this.purposeOneTreatment_}setAllVendorConsents(){this.vendorConsents.set(this.gvl.vendors)}unsetAllVendorConsents(){this.vendorConsents.empty()}setAllVendorsDisclosed(){this.vendorsDisclosed.set(this.gvl.vendors)}unsetAllVendorsDisclosed(){this.vendorsDisclosed.empty()}setAllVendorsAllowed(){this.vendorsAllowed.set(this.gvl.vendors)}unsetAllVendorsAllowed(){this.vendorsAllowed.empty()}setAllVendorLegitimateInterests(){this.vendorLegitimateInterests.set(this.gvl.vendors)}unsetAllVendorLegitimateInterests(){this.vendorLegitimateInterests.empty()}setAllPurposeConsents(){this.purposeConsents.set(this.gvl.purposes)}unsetAllPurposeConsents(){this.purposeConsents.empty()}setAllPurposeLegitimateInterests(){this.purposeLegitimateInterests.set(this.gvl.purposes)}unsetAllPurposeLegitimateInterests(){this.purposeLegitimateInterests.empty()}setAllSpecialFeatureOptins(){this.specialFeatureOptins.set(this.gvl.specialFeatures)}unsetAllSpecialFeatureOptins(){this.specialFeatureOptins.empty()}setAll(){this.setAllVendorConsents(),this.setAllPurposeLegitimateInterests(),this.setAllSpecialFeatureOptins(),this.setAllPurposeConsents(),this.setAllVendorLegitimateInterests()}unsetAll(){this.unsetAllVendorConsents(),this.unsetAllPurposeLegitimateInterests(),this.unsetAllSpecialFeatureOptins(),this.unsetAllPurposeConsents(),this.unsetAllVendorLegitimateInterests()}get numCustomPurposes(){let e=this.numCustomPurposes_;if("object"==typeof this.customPurposes){const t=Object.keys(this.customPurposes).sort(((e,t)=>Number(e)-Number(t)));e=parseInt(t.pop(),10)}return e}set numCustomPurposes(e){if(this.numCustomPurposes_=parseInt(e,10),this.numCustomPurposes_<0)throw new r("numCustomPurposes",e)}updated(){const e=new Date,t=new Date(Date.UTC(e.getUTCFullYear(),e.getUTCMonth(),e.getUTCDate()));this.created=t,this.lastUpdated=t}}class R{static encode(e,t){let s,r="";return e=_.process(e,t),s=Array.isArray(t?.segments)?t.segments:new V(e,t)[""+e.version],s.forEach(((t,n)=>{let i="";n<s.length-1&&(i="."),r+=w.encode(e,t)+i})),r}static decode(e,t){const s=e.split("."),r=s.length;t||(t=new T);for(let e=0;e<r;e++){const r=s[e],i=n.decode(r.charAt(0)).substr(0,f.segmentType),o=g.ID_TO_KEY[v.decode(i,f.segmentType).toString()];w.decode(r,t,o)}return t}}P.baseUrl="https://app.wplegalpages.com/rgh/";const N=new P;N.readyPromise.then((()=>{const e={},t=N.vendors,s=N.purposes,r=N.features,n=N.dataCategories,i=N.specialPurposes,o=N.specialFeatures,a=N.byPurposeVendorMap;var c=[],p=[],u=[],l=[],d=[],h=[],g=[],m=[],f=[],v=[],C=[],E=[],y=[],I=[],L=[],S=[],b=[];Object.keys(t).forEach((e=>{c.push(t[e]),p.push(t[e].id),t[e].legIntPurposes.length&&u.push(t[e].id)})),e.vendors=c,e.allvendors=p,e.allLegintVendors=u,Object.keys(r).forEach((e=>{d.push(r[e]),I.push(Object.keys(N.getVendorsWithFeature(r[e].id)).length)})),e.features=d,e.featureVendorCount=I,e.dataCategories=[],Object.keys(n).forEach((e=>{l.push(n[e])})),e.dataCategories=l;var A=0;const V=new Map;Object.keys(s).forEach((e=>{C.push(s[e]),f.push(s[e].id),y.push(Object.keys(N.getVendorsWithConsentPurpose(s[e].id)).length),A=Object.keys(N.getVendorsWithLegIntPurpose(s[e].id)).length,b.push(A),A&&(V.set(s[e].id,A),v.push(s[e].id))})),e.purposes=C,e.allPurposes=f,e.purposeVendorCount=y,e.allLegintPurposes=v,e.legintPurposeVendorCount=b,Object.keys(o).forEach((e=>{g.push(o[e]),h.push(o[e].id),S.push(Object.keys(N.getVendorsWithSpecialFeature(o[e].id)).length)})),e.specialFeatures=g,e.allSpecialFeatures=h,e.specialFeatureVendorCount=S,Object.keys(i).forEach((e=>{m.push(i[e]),L.push(Object.keys(N.getVendorsWithSpecialPurpose(s[e].id)).length)})),e.specialPurposes=m,e.specialPurposeVendorCount=L,Object.keys(a).forEach((e=>E.push(a[e].legInt.size))),e.purposeVendorMap=E,e.secret_key="sending_vendor_data";var w=new XMLHttpRequest;w.open("POST","test.php"),w.onreadystatechange=function(){4===w.readyState&&w.status},w.setRequestHeader("Content-type","application/json;charset=UTF-8"),w.send(JSON.stringify(e))}));const U=new T(N);U.cmpId=449,U.cmpVersion=1,U.vendorConsents.set([4,1,8]),U.vendorLegitimateInterests.set([8,10]),U.purposeConsents.set([2,4,6,7]),U.purposeLegitimateInterests.set([2,4,7]),U.specialFeatureOptins.set([1,2]),U.gvl.readyPromise.then((()=>{R.encode(U)}))})();