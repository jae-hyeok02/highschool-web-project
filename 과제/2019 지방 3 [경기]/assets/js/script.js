const dd = console.log;

// escape
var matchOperatorsRe = /[|\\{}()[\]^$+*?.]/g;

escape = function(str) {
	if (typeof str !== 'string') {
		throw new TypeError('Expected a string');
	}

	return str.replace(matchOperatorsRe, '\\$&');
};

// 가격 함수
function price(str) {
	return "￦ "+(((str+"").replace("원", "")*1).toLocaleString());
}

// ￦, 원, , 없애주는 함수
calc = parseInt;
function calc2(el) {
	return el.replace("￦", "").replace(",", "");
}

// 제목 함수
function title(t) {
	$("#page-inner > div:nth-child(1) > div > h2").text(t);
}

// 앨범 리스트 append 함수
function list(el) {
	$(".contents").append(`
		<div class="col-md-2 col-sm-2 col-xs-2 product-grid" data-cat="${el.category}">
            <div class="product-items">
                    <div class="project-eff">
                        <img class="img-responsive" src="/images/${el.albumJaketImage}" alt="${el.albumName}">
                    </div>
                <div class="produ-cost">
                    <h5>${el.albumName}</h5>
                    <span>
                        <i class="fa fa-microphone"> 아티스트</i> 
                        <p class="artist">${el.artist}</p>
                    </span>
                    <span>
                        <i class="fa  fa-calendar"> 발매일</i> 
                         
                        <p>${el.release}</p>
                    </span>
                    <span>
                        <i class="fa fa-money"> 가격</i>
                        <p>${price(el.price)}</p>
                    </span>
                    <span class="shopbtn">
                        <button class="btn btn-default btn-xs">
                            <i class="fa fa-shopping-cart"></i> 쇼핑카트담기
                        </button>
                    </span>
                </div>
            </div>
        </div>
	`);
}

// indexedDB 객체
const DB = {
	open(dbname) {
		return new Promise(res => {
			let req = indexedDB.open(dbname, 4);

			req.onupgradeneeded = function(e) {
				let db = e.target.result;

				db.createObjectStore("cart", {keyPath: "idx", autoIncrement: true});
			}

			req.onsuccess = function(e) {
				db = e.target.result;

				return res();
			}
		});
	},
	table(tbname) {
		return db.transaction([tbname], "readwrite").objectStore(tbname);
	}
}

// 기본 설정 & 이벤트 할당
const App = {
	init() {
		App.hook();

		Feed.setList();
		Feed.modalBtn();
		Feed.setCate();
	},
	hook() {
		$(document)
			.on("click", "#main-menu li a", Feed.changeCate)
			.on("keypress", Feed.setSearch)
			.on("click", "#main-menu > li.text-center > div > div > span > button", Feed.setSearch)
			.on("click", ".shopbtn button", Cart.add)
			.on("click", ".btn-lg", Cart.list)
			.on("input", ".albumqty input", Cart.price)
			.on("click", ".table-bordered tbody tr button", Cart.del)
			.on("click", "#myModal > div > div > div.modal-footer > button.btn.btn-primary", Cart.buy)
	}
}

// 메인 피드 객체
const Feed = {
	// 앨범 리스트 append
	setList() {
		$.each(jsonD, (ix, el) => {
			title("ALL");
			list(el);
			el.qty = 0;
		});
	},

	// 모달 버튼 업데이트
	modalBtn() {
		let qtyArr = [],
			priceArr = [];
		DB.table("cart").getAll().onsuccess =  e => {
			let data = e.target.result;

			if (!data.length)
				$(".btn-lg").html(`<i class="fa fa-shopping-cart"></i> 쇼핑카트 <strong>0</strong> 개 금액 ￦ 0원</a> `)
			else {
				$.each(data, (ix, el) => {
					qtyArr.push(el.qty);
					priceArr.push(calc(el.price)*el.qty);
					qtyTotal = qtyArr.reduce((a,b) => a+b);
					priceTotal = priceArr.reduce((a,b) => a+b);

					$(".btn-lg").html(`<i class="fa fa-shopping-cart"></i> 쇼핑카트 <strong>${qtyTotal}</strong> 개 금액 ${price(priceTotal)}원</a> `)
				});
			}
		};
	},

	// 카테고리 버튼 append
	setCate() {
		$("#main-menu").append(`
			<li>
                <a class="active-menu" data-cat="ALL" href="#"><i class="fa fa-th-list fa-2x"></i> <span>ALL</span></a>
            </li>
            <li>
                <a href="#" data-cat="발라드"><i class="fa fa-youtube-play fa-2x"></i> <span>발라드</span></a>
            </li>
            <li>
                <a href="#" data-cat="랩힙합"><i class="fa fa-youtube-play fa-2x"></i> <span>랩힙합</span></a>
            </li>
            <li>
                <a href="#" data-cat="포크어코스틱"><i class="fa fa-youtube-play fa-2x"></i> <span>포크어코스틱</span></a>
            </li>
            <li>
                <a href="#" data-cat="재즈"><i class="fa fa-youtube-play fa-2x"></i> <span>재즈</span></a>
            </li>
            <li>
                <a href="#" data-cat="트로트"><i class="fa fa-youtube-play fa-2x"></i> <span>트로트</span></a>
            </li>
            <li>
                <a href="#" data-cat="댄스"><i class="fa fa-youtube-play fa-2x"></i> <span>댄스</span></a>
            </li>
            <li>
                <a href="#" data-cat="락메탈"><i class="fa fa-youtube-play fa-2x"></i> <span>락메탈</span></a>
            </li>
            <li>
                <a href="#" data-cat="R&B"><i class="fa fa-youtube-play fa-2x"></i> <span>R&B</span></a>
            </li>
            <li>
                <a href="#" data-cat="팝"><i class="fa fa-youtube-play fa-2x"></i> <span>팝</span></a>
            </li>
		`);
	},

	// 카테고리 변경 함수
	changeCate(e) {
		e.preventDefault();
		let listD = $(this).data("cat");

		$(".product-grid").hide();

		$("#main-menu li a").removeClass("active-menu");
		$(this).addClass("active-menu");

		$(".product-grid").each((ix, el) => {
			let catD = $(el).data("cat");
			if (listD) {
				title(listD);
				if (listD == catD) {
					$(el).show();
				}
			}
		});

		if (listD === "ALL") {
			title("ALL");
			$(".product-grid").show();
		}
	},

	// 검색 이벤트 마다 실행 여부
	setSearch(e) {
		if (e.which == 13 || e.keyCode == 13)
			Feed.search();
		else if (e.type === "click")
			Feed.search();
	},

	// 검색 함수
	search() {
		let searchV = $("#main-menu > li.text-center > div > div > input").val(),
			titleCond = new RegExp(escape(searchV), "gi"),
			searchCond = new RegExp(`.*${escape(searchV)}.*`, "g"),
			filt = jsonD.filter(v => titleCond.test(v.albumName) || titleCond.test(v.artist));

		$(".product-grid").remove();
		title($(".active-menu").data("cat"));

		$.each(jsonD, (ix, el) => {
			if (searchCond.test(el.albumName) || searchCond.test(el.artist)) {
				list(el);
			}
		});

		$(`.produ-cost h5, .artist:contains(${escape(searchV)})`).each((ix, el) => {
			$(el).html($(el).text().replace(titleCond, `<mark>${searchV}</mark>`));
		});

		if (!filt.length) {
			title("검색된 결과가 없습니다."); 
		}
	}
}

// 쇼핑카트 함수
const Cart = {
	// 카트에 앨범리스트 추가 함수
	add() {
		DB.table("cart").getAll().onsuccess = e => {
			let data = e.target.result,
				titleV = $(this)
					.closest(".produ-cost")
					.find("h5")
					.text();

			let D = data.find(v => v.albumName === titleV) || jsonD.find(v => v.albumName === titleV);
			D.qty++;

			$(this).html(`<i class="fa fa-shopping-cart"></i> 추가하기 (${D.qty}개)`);

			DB.table("cart").put(D);

			Feed.modalBtn();
		}
	},
	// 카트 리스트 append 함수
	list() {
		$(".totalprice").remove();
		$(".table-bordered tbody tr").remove();
		DB.table("cart").getAll().onsuccess = e => {
			let data = e.target.result,
				totalArr = [];

			$.each(data, (ix, el) => {
				totalArr.push(calc(el.price)*el.qty);
				total = totalArr.reduce((a,b) => a+b);

				$(".table-bordered tbody").append(`
					<tr>
			            <td class="albuminfo">
			                <img src="/images/${el.albumJaketImage}">
			                <div class="info">
			                    <h4>${el.albumName}</h4>
			                    <span>
			                        <i class="fa fa-microphone"> 아티스트</i> 
			                        <p>${el.artist}</p>
			                    </span>
			                    <span>
			                        <i class="fa  fa-calendar"> 발매일</i> 
			                        <p>${el.release}</p>
			                    </span>
			                </div>
			            </td>
			            <td class="albumprice">
			                ${price(el.price)}
			            </td>
			            <td class="albumqty">
			                <input type="number" class="form-control cnt" min="1" value="${el.qty}" data-name="${el.albumName}" data-price="${calc(el.price)}">
			            </td>
			            <td class="pricesum">
			                ${price(calc(el.price)*el.qty)}
			            </td>
			            <td>
			                <button class="btn btn-default" data-idx="${el.idx}">
			                    <i class="fa fa-trash-o"></i> 삭제
			                </button>
			            </td>
			        </tr>
				`);

			});

			if (!data.length) {
				$(".modal-body").append(`
					<div class="totalprice text-right">
	                    <h3>총 합계금액 : <span>￦ 0</span> 원</h3>
	                </div>
				`);
			} else {
				$(".modal-body").append(`
					<div class="totalprice text-right">
	                    <h3>총 합계금액 : <span>${price(total)}</span> 원</h3>
	                </div>
				`);
			}
			
		}
		
	},

	// 가격 갱신 함수
	price() {
		let curV = $(this).val(),
			nameD = $(this).data("name"),
			priceD = $(this).data("price"),
			totalArr = [];

		$(".totalprice").remove();

		$(this).attr("value", curV);
		let inputV = $(this).attr("value");

		$(this)
			.closest("tr")
			.find(".pricesum")
			.text(price(calc(priceD)*inputV));

		DB.table("cart").getAll().onsuccess = e => {
			let data = e.target.result,
				test = data.find(v => v.albumName == nameD);

			test.qty = Number(inputV);

			$.each(data, (ix, el) => {
				totalArr.push(calc(el.price)*el.qty);
				total = totalArr.reduce((a,b) => a+b);
			});

			$(".modal-body").append(`
				<div class="totalprice text-right">
                    <h3>총 합계금액 : <span>${price(total)}</span> 원</h3>
                </div>
			`);

			DB.table("cart").put(test);

			Feed.modalBtn();
		};
	},

	// 삭제 함수
	del() {
		let idx = $(this).data("idx");

		if (!confirm("정말 삭제 하시겠습니까?")) return false;

		DB.table("cart").delete(idx);

		Cart.list();

		Feed.modalBtn();
	},

	// 결제 함수
	buy() {
		DB.table("cart").getAll().onsuccess = e => {
			let data = e.target.result;

			if (!data.length) {
				alert("결제할 앨범이 없습니다.");
				return false;
			}

			$.each(data, (ix, el) => {
				let idx = el.idx;
				DB.table("cart").delete(idx);
			});

			Feed.modalBtn();

			alert("결제가 완료되었습니다.");

			$(".modal").modal("hide");
		};
	}
}

// window 로드 되었을때
window.onload = function(e) {
	DB.open("music").then(function() {
		$.getJSON("/music_data.json", function(data) {
			jsonD = data.data;

			jsonD.sort((a,b) => {
				let dataA = new Date(a.release).getTime(),
					dataB = new Date(b.release).getTime();

				return dataA < dataB ? 1 : -1;
			});

			$(".product-grid").remove();
			$("#main-menu li:not(:first-child)").remove();

			App.init();
		});
	});
	
}