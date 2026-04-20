class CardTest {

  List<Map<String, dynamic>> promotions = [
    {
      "id": "1bv",
      "promotype": "quick",
      "promotion": {
        "amount": 100,
        "items":
          {
            "inStock":[
              {
                "productName": "Castel",
                "qty": 3,
                "price":0,

              },
              {
                "productName": "Simba",
                "qty": 3,
                "price":0,

              }
            ],
            "OutStock":[],
          }

      },
      "condition": {
        "allowProduct": "Only",
        "products": ["ibijumba"],
        "exProducts": ["simba", "fanta"],
        "TotalToCount": "cCount",
        "cartTotal":500,
        "cartCount": 10,
        "card": "yes",
      }
    },
    {
      "id": "2xb",
      "promotype": "quick",
      "promotion": {
        "amount": 400,
        "items":
        {
          "inStock":[
            {
              "productName": "Castel",
              "qty": 1,
              "price":0,
              "inStock": "yes"
            },
            {
              "productName": "Simba",
              "qty": 1,
              "price":0,
              "inStock": "yes"
            }
          ],
          "OutStock":[],
        }
      },
      "condition": {
        "allowProduct": "Only",
        "products": ["bread"],
        "exProducts": ["simba", "fanta"],
        "TotalToCount": "both",
        "cartTotal": 500,
        "cartCount": 5,
        "card": "yes",
      }
    },
    {
      "id": "fbx",
      "promotype": "long",
      "promotion": {
        "amount": 500,
        "items": {
          "inStock": [
            {"productName": "castel", "qty": 3, "price": 0, "inStock": "yes"},
            {"productName": "primus", "qty": 2, "price": 0, "inStock": "yes"}
          ]
        }
      },
      "condition": {
        "allowProduct": "Only",
        "products": ["simba"],
        "exProducts": ["simba", "fanta"],
        "TotalToCount": "both",
        "cartTotal": 100,
        "cartCount": 50,
        "card": "yes",
      }
    },
    {
      "id": "fbv",
      "promotype": "long",
      "promotion": {
        "amount": 400,
        "items": {
          "inStock": [
            {"productName": "castel", "qty": 7, "price": 0, "inStock": "yes"},
            {"productName": "serengeti", "qty": 3, "price": 0, "inStock": "yes"}
          ]
        }
      },
      "condition": {
        "allowProduct": "Only",
        "products": ["beans"],
        "exProducts": ["simba", "fanta"],
        "TotalToCount": "both",
        "cartTotal": 15000,
        "cartCount": 5,
        "card": "yes",
      }
    }
  ];

}