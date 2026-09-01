import 'package:dstockapp/Utilconfig/ConstantClassUtil.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';


class PageLoaderWrapper extends StatelessWidget {
  final Widget child;

  const PageLoaderWrapper({super.key, required this.child});

  @override
  Widget build(BuildContext context) {
    final loadingController = Get.put(ConstantClassUtil());

    return Stack(
      children: [
        // 1. Your actual page screen content
        child,

        // 2. The exact styled loading box (covers only the body)
        Obx(() {
          if (!loadingController.isLoading.value) {
            return const SizedBox.shrink();
          }

          return Positioned.fill(
            child: Container(
              color: Colors.black.withOpacity(0.25), // Softened backdrop overlay
              child: Center(
                child: Container(
                  padding: const EdgeInsets.symmetric(horizontal: 28, vertical: 24),
                  constraints: const BoxConstraints(minWidth: 140, maxWidth: 220),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(20),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withOpacity(0.08),
                        blurRadius: 24,
                        spreadRadius: 0,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const SizedBox(
                        width: 28,
                        height: 28,
                        child: CircularProgressIndicator(
                          strokeWidth: 2.5,
                          valueColor: AlwaysStoppedAnimation<Color>(Colors.blueAccent),
                          strokeCap: StrokeCap.round,
                        ),
                      ),
                      if (loadingController.message.value.isNotEmpty) ...[
                        const SizedBox(height: 16),
                        Text(
                          loadingController.message.value,
                          textAlign: TextAlign.center,
                          style: GoogleFonts.poppins(
                            color: const Color(0xFF2D3748),
                            fontWeight: FontWeight.w500,
                            fontSize: 13,
                            height: 1.2,
                            decoration: TextDecoration.none,
                          ),
                        ),
                      ],
                    ],
                  ),
                ),
              ),
            ),
          );
        }),
      ],
    );
  }
}