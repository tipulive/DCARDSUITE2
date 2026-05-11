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
        "products": ["nyota","macon"],
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
        "amount": 100,
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
        "TotalToCount": "cCount",
        "cartTotal": 300,
        "cartCount": 10,
        "card": "yes",
      }
    },
    {
      "id": "bmv",
      "promotype": "quick",
      "promotion": {
        "amount": 200,
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
              "productName": "ibijumba",
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
        "products": ["simba"],
        "exProducts": ["simba", "fanta"],
        "TotalToCount": "cCount",
        "cartTotal": 500,
        "cartCount": 5,
        "card": "yes",
      }
    },

  ];

}