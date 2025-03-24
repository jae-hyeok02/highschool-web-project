const dd = console.log;

const App = { 

	init() {
		this.hook();

		$(".time__modal").hide();

		if (location.pathname == "/showingtime") ShowingTime.init();

		Login.init();
		ShowingBuy.init();
		ShowRequire.init();
		SponsorManage.init();
		ShowManage.init();
		RequireManage.init();
		CinemaManage.init();
	},

	hook() {
		
	}
}

// 상영요청
const ShowRequire = {

	init() {
		this.hook();
	},

	hook() {
		$(document)
			.on("click", ".mov__require form button", this.chk)
	},
	
	chk() {

		let image = new Image();
		let running = new RegExp(/^[0-9]+$/, "g");
		let number = new RegExp(/^\d{3}-\d{4}-\d{4}$/, "g");
		let busniess = new RegExp(/^\d{3}-\d{2}-\d{5}$/, "g");
		let email = new RegExp(/^[a-z0-9]([-_.]?[a-z0-9])*@[a-z0-9]([-_.]?[a-z0-9])*.[a-z]{2,3}$/, "i");

		$('.reg1').remove();
		$('.reg2').remove();
		$('.reg3').remove();
		$('.reg4').remove();
		$('.reg5').remove();

		$(".mov__require--valuechk").empty();

		// 값 여부 & 공백 체크
		$(this).parents(".content").find("input").each((i, v) => {
			if (!v.value || v.value.search(/\s/) != -1) {
				$(".mov__require--valuechk").html("<span class='mov_require' style='color: red;'>모든 값을 입력해주세요.</span>");
			}
		});

		// 이미지 검사
		image.src = "/public/images/"+$(".mov__require #mov_poster--val").val();

		image.onerror = function() {
			$(".mov__require #mov_poster")
				.parent()
				.append("<p class='mov_require reg5' style='color: red'>올바른 형태의 이미지 파일이 아닙니다.</p>");
		}

		if (!email.test($('.mov__require #company_email').val())) {
			$('.mov__require #company_email')
				.parent()
				.append("<p class='mov_require reg1' style='color: red'>올바른 형태의 이메일이 아닙니다.</p>");
		}

		if (!busniess.test($('.mov__require #busniess_num').val())) {
			$('.mov__require #busniess_num')
				.parent()
				.append("<p class='mov_require reg2' style='color: red'>올바른 사업자 등록번호가 아닙니다.</p>");
		}

		if (!number.test($(".mov__require #company_num").val())) {
			$(".mov__require #company_num")
				.parent()
				.append("<p class='mov_require reg3' style='color: red'>올바른 형태의 전화번호가 아닙니다.</p>");
		}

		if (!running.test($(".mov__require #running_time").val())) {
			$(".mov__require #running_time")
				.parent()
				.append("<p class='mov_require reg4' style='color: red'>올바른 형태의 러닝타임이 아닙니다.</p>");
		}

		if (!$(this).parents(".content").find(".mov_require").hasClass("mov_require")) {
			$(this).parents(".content").find("form")[0].onsubmit = '';
		}
	},
}

// 관리자 로그인
const Login = {

	init() {
		this.hook();
	},

	hook() {
		$(document)
			.on("click", ".login form button", this.chk)
	},

	chk() {

		$('.login1').remove();
		$('.login2').remove();
		$('.login3').remove();

		if (!$('.login #id').val()) {
			$('.login #id')
				.parent()
				.append("<p class='login1' style='color: red'>아이디를 입력해주세요.</p>");
		}

		if (!$('.login #pw').val()) {
			$('.login #pw')
				.parent()
				.append("<p class='login2' style='color: red'>아이디를 입력해주세요.</p>");
		}

		if (!$('.login #id').val() || !$('.login #pw').val()) {
			$('.login form > div:first-child').append("<p class='login3' style='color: red'>아이디 및 비밀번호를 입력해주세요.</p>")
		}

		if ($('.login #id').val() && $('.login #pw').val()) {
			$(this).parents(".content").find("form")[0].onsubmit = '';
		}
	},
	
}

// 상영작 예매
const ShowingBuy = {

	init() {
		this.hook();
	},

	hook() {
		$(document)
			.on("click", ".seat__insert", this.seatInsertVal)
			.on("click", ".showing__buy form button", this.chk)
			.on("change", "select[name=cinema_idx]", this.cinema)
			.on("change", "select[name=movie_idx]", this.viewSeat)
			.on("click", ".seat__btn--enable", this.insertSeatVal)
			.on("click", ".seat__btn--disable", this.clickDisBtn)
	},

	seatInsertVal() {
		$("#mov_seat").val($(this).attr("id"));
	},

	cinema() {

		if (!$(this).val()) {

			$(".showing__buy #movie_idx")
				.attr("disabled", true)
				.val('');

			return false;
		}

		$.post(`/ajax/cinema`, {idx: $(this).val()}, function(res) {

			data = JSON.parse(res);

			let html = `
				<option value="">선택</option>
			`;

			$.each(data, (ix, el) => {

				html += `
					<option value="${el.idx}">${el.mov_name}</option>
				`;
			});

			$(".showing__buy #movie_idx").attr("disabled", false);

			$(".showing__buy #movie_idx").html(html);

			$(".seat ul").empty();
			$("#mov_seat").val('');
		});
	},

	viewSeat() {

		$("#mov_seat").val('');
		$(".seat ul li").remove();

		if (!$(this).val()) return false;

		let alphabet = 'abcdefghijklmnopqrstuvwxyz'.split('');

		// 좌석 데이터 띄우기
		$.post('/ajax/movie', {idx: $("select[name=cinema_idx]").val(), movie_idx: $("select[name=movie_idx]").val()}, function(res) {

			data = JSON.parse(res);

			$.each(data, (ix, el) => {

				$(".seat ul").append('<li></li>');
			
				$(".seat ul li").css({
					width: el.length * 30+"px",
				});

				$.each(el.split(""), (i, v) => {

					switch (v) {
						case "0":
							$(".seat ul li").append(`<p class='seat__0 seat__btn' id='${i+1}'></p>`);
							break;
						case "1":
							$(".seat ul li").append(`<p class='seat__1 seat__btn seat__btn--enable' id='${i+1}'></p>`);
							break;
						case "2":
							$(".seat ul li").append(`<p class='seat__2 seat__btn seat__btn--enable' id='${i+1}'></p>`);
							break;
						case "3":
							$(".seat ul li").append(`<p class='seat__3 seat__btn seat__btn--enable' id='${i+1}'></p>`);
							break;
					}

					$(".seat li:not(:first-child)").remove();

					for (let val = 0; val <= data.length; val++) {
						$(`.seat__btn:nth-child(${(el.length*val)+(i+1)})`).attr("id", `${(i+1)+alphabet[val]}`);
					}
				});
			});
		});

		// 좌석 disabled
		$.post('/ajax/seatchk', {idx: $("select[name=cinema_idx]").val(), movie_idx: $("select[name=movie_idx]").val()}, function(res) {

			// 선택된 좌석이 없는 영화이면 내보냄
			if (!res) return false; 

			data = JSON.parse(res);

			$.each(data, (ix, el) => {

				$(`.seat ul li p[id=${el}]`)
					.removeClass('seat__btn--enable')
					.addClass('seat__btn--disable');
			});
		});
	},

	clickDisBtn() {

		alert("이미 다른 사람이 선택한 좌석이므로 선택이 불가능합니다.");
		return false;
	},

	insertSeatVal() {

		$("#mov_seat").val(this.id);
	},

	chk() {

		let number = new RegExp(/^\d{3}-\d{4}-\d{4}$/, "g"); 

		$(".showing_buy1").remove();
		$(".showing_buy2").remove();
		$(".showing__buy--valueChk").empty();

		$(this).parents(".content").find("input").each((i, v) => {
			if (!v.value || v.value.search(/\s/) != -1) {
				$(".showing__buy--valueChk").html("<span class='showing_buy' style='color: red;'>모든 값을 입력해주세요.</span>");
			}
		});

		if (!number.test($(".showing__buy #phone_number").val())) {

			$(".showing__buy #phone_number")
				.parent()
				.append("<p class='showing_buy showing_buy1' style='color: red'>올바른 형태의 휴대폰 번호가 아닙니다.</p>");
		}

		if (!$("#mov_seat").val()) {

			$("#mov_seat")
				.parent()
				.append("<p class='showing_buy showing_buy2' style='color: red'>좌석을 선택해주세요</p>");
		}

		if (!$(this).parents(".content").find(".showing_buy").hasClass("showing_buy")) {
			$(this).parents(".content").find("form")[0].onsubmit = '';
		}

	},

}

// 스폰서 관리
const SponsorManage = {

	init() {
		this.hook();
	},

	hook() {
		$(document)
			.on("click", ".sponsor__manage form button", this.chk)
			.on("click", ".sponsor__manage table tbody td:first-child", this.view)
			.on("click", ".sponsor__close", this.close)

	},

	chk() {
		let image = new Image();
		let unitReg = new RegExp(/[0]{4}$/, "g");
		let priceReg = new RegExp(/^[0-9]+$/, "g");

		$('.sponsor_manage1').remove();
		$('.sponsor_manage2').remove();
		$('.sponsor_manage3').remove();
		$('.sponsor_manage4').remove();
		$(".sponsor__manage--valueChk").empty();

		// 빈값 체크
		$(this).parents(".content").find("input").each((i, v) => {
			if (!v.value) {
				$(".sponsor__manage--valueChk").html("<span class='sponsor_manage' style='color: red;'>모든 값을 입력해주세요.</span>");
			}
		});

		// 이미지 검사
		image.src = "/public/images/"+$(".sponsor__manage #sponsor_logo--val").val();

		image.onerror = function() {
			$(".sponsor__manage #sponsor_logo")
				.parent()
				.append("<p class='sponsor_manage sponsor_manage1' style='color: red'>올바른 형태의 이미지 파일이 아닙니다.</p>");
		}

		// 정규식
		if (!priceReg.test($(".sponsor__manage #support_price").val())) {

			$(".sponsor__manage #support_price")
				.parent()
				.append("<p class='sponsor_manage sponsor_manage2' style='color: red'>올바른 형태의 금액이 아닙니다.</p>");
		}

		if (!unitReg.test($(".sponsor__manage #support_price").val()) || $(".sponsor__manage #support_price").val() < 10000) {

			$(".sponsor__manage #support_price")
				.parent()
				.append("<p class='sponsor_manage sponsor_manage3' style='color: red'>후원은 만원 단위로만 가능합니다.</p>");
		}

		if ($(".sponsor__manage #support_price").val() < 1000000) {

			$(".sponsor__manage #support_price")
				.parent()
				.append("<p class='sponsor_manage sponsor_manage4' style='color: red'>후원은 100만원 이상 가능합니다.</p>");
		}
		// typeof($(".sponsor__manage #support_price").val()) !== "number"

		if (!$(this).parents(".content").find(".sponsor_manage").hasClass("sponsor_manage")) {
			$(this).parents(".content").find("form")[0].onsubmit = '';
		}
	},

	view() {

		$.post('/ajax/sponsor', {idx: $(this).data("idx")}, function(res) {
			data = JSON.parse(res);

			$(".sponsor__popup img").attr("src", "/public/upload/"+data);
		});

		$("body")
			.prepend(`
				<div class="sponsor__modal">
					<div class="sponsor__popup">
						<p class='sponsor__close pointer'>X</p>
						<img src="" alt="sponsor_logo" />
					</div>					
				</div>
			`);
	},

	close() {
		$(".sponsor__modal").hide();
	},

}

// 공식 상영작 관리
const ShowManage = {

	init() {
		this.hook();
		this.createPopup();

		$(".showing__modal").hide();
	},

	hook() {
		$(document)
			.on("click", ".showing__manage form button", this.chk)
			.on("click", ".showing__manage table tbody td:first-child", this.viewPopup)
			.on("click", ".showing__close", this.closePopup)
	},

	chk() {

		let image = new Image();
		let running = new RegExp(/^[0-9]+$/, "g");

		$(".showing_manage1").remove();
		$(".showing_manage2").remove();
		$(".showing__manage--valueChk").empty();

		$(this).parents(".content").find("input").each((i, v) => {
			if (!v.value) {
				$(".showing__manage--valueChk").html("<span class='showing_manage' style='color: red;'>모든 값을 입력해주세요.</span>");
			}
		});


		image.src = "/public/images/"+$(".showing__manage #mov_poster--val").val();

		image.onerror = function() {
			$(".showing__manage #mov_poster")
				.parent()
				.append("<p class='showing_manage showing_manage2' style='color: red'>올바른 형태의 이미지 파일이 아닙니다.</p>");
		}

		if (!running.test($(".showing__manage #running_time").val())) {
			$(".showing__manage #running_time")
				.parent()
				.append("<p class='showing_manage showing_manage1' style='color: red'>올바른 형태의 러닝타임이 아닙니다.</p>");
		}

		if (!$(this).parents(".content").find(".showing_manage").hasClass("showing_manage")) {
			$(this).parents(".content").find("form")[0].onsubmit = '';
		}

	},

	createPopup() {

		$("body")
			.prepend(`
				<div class="showing__modal">
					<div class="showing__popup">
						<p class='showing__close pointer'>X</p>
						<img src="" alt="showing_img" />
					</div>			
				</div>
			`);
	},

	viewPopup() {
		$(".showing__modal").show();

		$.post('/ajax/showmanage', {idx: $(this).data('idx')}, function(res) {
			data = JSON.parse(res);

			$(".showing__popup img").attr("src", "/public/upload/"+data);
		});
	},

	closePopup() {
		$(".showing__modal").hide();
	},

}

// 요청작 관리
const RequireManage = {

	init() {
		this.hook();

		$(".require__modal").hide();
	},

	hook() {
		$(document)
			.on('click', '.require__manage table tbody .pointer', this.viewPopup)
			.on("click", ".require__close", this.closePopup)
	},

	viewPopup() {

		$.post('/ajax/require', {idx: $(this).data('idx')}, function(res) {

			$(".require__modal").remove();
			data = JSON.parse(res);

			$("body")
				.prepend(`
					<div class="require__modal">
						<div class="require__popup">
							<p class='require__close pointer'>X</p>
							<p>영화사명 : ${data.company_name}</p>
							<p>사업자등록번호 : ${data.busniess_num}</p>
							<p>영화사 대표 이메일 : ${data.company_email}</p>
							<p>영화사 대표 전화번호 : ${data.company_num}</p>
						</div>
					</div>
				`);
		});
	},

	closePopup() {
		$(".require__modal").hide();
	},
}


// 상영시간표
const ShowingTime = {

	init() {
		this.hook();

		$(".time__modal").hide();

		// 시작위치 0 (눈금 8)
		// 종료위치 1080(18*60) (눈금 26)      * 100 : 백분율
		// 수식 : (종료시간 - 시작시간) / 1080 * 100 => 가로길이 (%)

		$(".timetable__bar--val").css({
			display: 'flex',
			justifyContent: 'center',
			alignItems: 'center',
			height: '100%',
			background: '#e0e0e0',
			borderLeft: '1px solid black',
			borderRight: '1px solid black',
		});

		let movStart = JSON.parse(movtime);

		$(".timetable__bar--val").each((ix, el) => {

			let endDate = $(el).prev().data('end');

			let running_time = this.decodeTime(this.time($(el).data("time")));

			let cond = this.startTime($(el).data('start')) - (endDate != undefined ? this.startTime(endDate) : 0);

			$(`.timetable__bar--val[data-name=${$(el).data('name')}]`).css({
				width: `${(running_time) / 1080 * 100}%`,
				marginLeft: `${cond === 0 ? cond : cond + 20}px`
			});
		});
	},

	hook() {
		$(document)
			.on("click", ".showing__timetable table tbody td:first-child", this.viewPopup)
			.on("click", ".time__close", this.closePopup)
	},

	time(minute) {

		if (typeof(minute) !== "number") return false;

		minute += 20;

		let hour = Math.floor(minute / 60);
		let min = minute % 60;

		if (min <= 9) min = "0" + min;

		return hour+":"+min;

		// 합산한 분(+20분까지)을 시간으로 바꿔줘야 함

		// ex) 160 -> 3
		//	   150 -> 2:50
	},

	decodeTime(time) {
		let timeArr = time.split(':');

		return timeArr[0] * 60 + Number(timeArr[1]);
	},

	startTime(el) {
		return this.decodeTime(el) - 480;
	},

	viewPopup() {

		$(".time__modal").show();

		$(".time__modal h2").text(this.innerHTML);

		$(".time__modal input[name=movie_idx]").val(this.innerHTML);
	},

	closePopup() {
		$(".time__modal").hide();
	},

}


// 영화관 관리
const CinemaManage = {

	init() {
		this.hook();
		this.create();

		$(".cinema__modal").hide();
	},

	hook() {
		$(document)
			.on("click", ".cinema__popup--open", this.viewPopup)
			.on("click", ".cinema__close", this.closePopup)
	},

	create() {

		$("body")
			.prepend(`
				<div class="cinema__modal">
					<div class="cinema__popup">
						<p class='cinema__close pointer'>X</p>
						<p>asd</p>
						<p>test</p>
					</div>
				</div>
			`);
	},

	viewPopup() {
		$(".cinema__modal").show();
	},

	closePopup() {
		$(".cinema__modal").hide();
	},

}

$(function() {
	App.init();
});

