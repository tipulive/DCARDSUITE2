class Promotions {
  final int? id;
  final String? uid;
  final String? uidCreator;
  final String? subscriber;
  final String? token;
  final String? promoName;
  final String? promoData;
  final String? promo_msg;
  final String? reach;
  final String? gain;
  final String? type_service;
  final String? started_date;

  final String? ended_date;
  final String? status;

  final String? created_at;
  final String? updated_at;


  Promotions({
    this.id,
    this.uid,
    this.uidCreator,
    this.subscriber,
    this.token,
    this.promoName,
    this.promoData,
    this.promo_msg,
    this.reach,
    this.gain,
    this.type_service,
    this.started_date,

    this.ended_date,
    this.status,

    this.created_at,
    this.updated_at

  });

  factory Promotions.fromMap(Map<String, dynamic> json) => new Promotions(
      id:json['id'],
      uid:json['uid'],
      uidCreator:json['uidCreator'],
      subscriber:json['subscriber'],
      token:json['token'],
      promoName:json['promoName'],
      promoData:json['promoData'],
      promo_msg:json['promo_msg'],
      reach:json['reach'],
      gain:json['gain'],
      type_service:json['type_service'],
      started_date:json['started_date'],

      ended_date:json['ended_date'],
      status:json['status'],

      created_at:json['created_at'],
      updated_at:json['updated_at']
  );

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'uid': uid,
      'uidCreator':uidCreator,
      'subscriber':subscriber,
      'token':token,
      'promoName':promoName,
      'promoData':promoData,
      'promo_msg':promo_msg,
      'reach':reach,
      'gain':gain,
      'type_service':type_service,
      'started_date':started_date,

      'ended_date':ended_date,
      'status': status,

      'created_at': created_at,
      'updated_at': updated_at

    };
  }
}
